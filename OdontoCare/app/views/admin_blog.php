<?php
require_once __DIR__ . "/../core/auth.php";
requireAdminLogin();

require_once __DIR__ . "/../core/blog_functions.php";

// To access/Para acessar: OdontoCare/login

$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($baseUrl === '' || $baseUrl === '.') $baseUrl = '';

// =============================
// Handle POST actions
// =============================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $folder = "app/core/uploads/";
    if (!is_dir($folder)) mkdir($folder, 0755, true);

    // CREATE or UPDATE
    if ($action === 'create' || $action === 'update') {
        $post_id = $_POST['post_id'] ?? null;
        $mediaName = null;
        $mediaType = null;

        // Handle media upload (image or video)
        if (!empty($_FILES['media']['name'])) {
            $result = validateMedia($_FILES['media']);
            if ($result !== true) {
                $_SESSION['admin_error'] = $result;
                header('Location: admin_blog.php');
                exit;
            }
            
            $mediaName = uniqid() . "_" . basename($_FILES['media']['name']);
            if (!move_uploaded_file($_FILES['media']['tmp_name'], $folder . $mediaName)) {
                $_SESSION['admin_error'] = 'Erro ao salvar o arquivo de mídia.';
                header('Location: admin_blog.php');
                exit;
            }
            
            // Determine media type
            $fileExtension = strtolower(pathinfo($mediaName, PATHINFO_EXTENSION));
            $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $videoExtensions = ['mp4', 'mov', 'avi', 'webm'];
            
            if (in_array($fileExtension, $imageExtensions)) {
                $mediaType = 'image';
            } elseif (in_array($fileExtension, $videoExtensions)) {
                $mediaType = 'video';
            }

            if ($action === 'update' && $post_id) {
                $old_post = getPostById($post_id);
                if ($old_post['media'] && file_exists($folder . $old_post['media'])) {
                    unlink($folder . $old_post['media']);
                }
            }
        }

        $destaque = isset($_POST['destaque']) ? 1 : 0;

        if ($action === 'create') {
            $stmt = (new Conexao())->getConexao()->prepare(
                "INSERT INTO publicacoes (titulo, autor, tempo_leitura, media, media_type, conteudo, destaque) VALUES (?, ?, ?, ?, ?, ?, ?)"
            );
            $stmt->execute([
                $_POST['title'], 
                $_POST['author'], 
                $_POST['reading_time'], 
                $mediaName, 
                $mediaType, 
                $_POST['content'], 
                $destaque
            ]);
        } else {
            updatePostWithMedia(
                $post_id, 
                $_POST['title'], 
                $_POST['author'], 
                $_POST['reading_time'], 
                $_POST['content'], 
                $destaque, 
                $mediaName, 
                $mediaType
            );
        }

        $_SESSION['admin_success'] = 'Ação realizada com sucesso!';
        header('Location: admin_blog.php');
        exit;
    }

    // TOGGLE FEATURED
    if ($action === 'toggle_featured' && isset($_POST['post_id'])) {
        toggleFeatured($_POST['post_id']);
        $_SESSION['admin_success'] = 'Ação realizada com sucesso!';
        header('Location: admin_blog.php');
        exit;
    }
}

// =============================
// Handle GET actions (DELETE)
// =============================
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $post = getPostById($id);
    if ($post['media'] && file_exists("app/core/uploads/" . $post['media'])) {
        unlink("app/core/uploads/" . $post['media']);
    }
    $stmt = (new Conexao())->getConexao()->prepare("DELETE FROM publicacoes WHERE id = ?");
    $stmt->execute([$id]);
    $_SESSION['admin_success'] = 'Artigo excluído com sucesso!';
    header('Location: admin_blog.php');
    exit;
}

// =============================
// Fetch all posts for display
// =============================
$posts = getAllPosts();
$editing_post = isset($_GET['edit']) ? getPostById($_GET['edit']) : null;

// Get messages from session
$success_message = $_SESSION['admin_success'] ?? '';
$error_message = $_SESSION['admin_error'] ?? '';

// Clear messages after retrieving
unset($_SESSION['admin_success'], $_SESSION['admin_error']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Blog | OdontoCare</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="<?= $baseUrl ?>/public/css/admin_blog.css">
</head>
<body>
<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0"><i class="fas fa-newspaper me-2"></i> Painel do Blog - OdontoCare</h2>
    <a href="app/core/logout.php" class="btn btn-outline-danger btn-sm">
      <i class="fas fa-sign-out-alt me-1"></i>Sair
    </a>
  </div>

  <!-- Feedback messages with dismiss buttons -->
  <?php if ($success_message): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($success_message) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
  <?php endif; ?>

  <?php if ($error_message): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= htmlspecialchars($error_message) ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
  <?php endif; ?>

  <!-- Formulário de Novo/Editar Artigo -->
  <div class="card p-4 mb-5">
    <h5 class="fw-semibold mb-3">
      <?= $editing_post ? 'Editar Artigo' : 'Adicionar novo artigo' ?>
      <?php if ($editing_post): ?>
        <a href="admin_blog.php" class="btn btn-sm btn-outline-secondary ms-2">Cancelar Edição</a>
      <?php endif; ?>
    </h5>
    <form action="admin_blog.php" method="POST" enctype="multipart/form-data" id="postForm">
      <input type="hidden" name="action" value="<?= $editing_post ? 'update' : 'create' ?>">
      <?php if ($editing_post): ?>
        <input type="hidden" name="post_id" value="<?= $editing_post['id'] ?>">
      <?php endif; ?>

      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Título</label>
          <input type="text" name="title" class="form-control" value="<?= $editing_post ? htmlspecialchars($editing_post['titulo']) : '' ?>" required>
        </div>
        <div class="col-md-3">
          <label class="form-label">Autor</label>
          <input type="text" name="author" class="form-control" value="<?= $editing_post ? htmlspecialchars($editing_post['autor']) : '' ?>">
        </div>
        <div class="col-md-3">
          <label class="form-label">Tempo de leitura</label>
          <input type="text" name="reading_time" class="form-control" placeholder="5 min" value="<?= $editing_post ? htmlspecialchars($editing_post['tempo_leitura']) : '' ?>">
        </div>
        <div class="col-md-12">
          <label class="form-label">Mídia de destaque (imagem ou vídeo)</label>
          <input type="file" name="media" class="form-control" id="mediaInput" accept=".jpg,.jpeg,.png,.gif,.webp,.mp4,.mov,.avi,.webm">
          <div class="form-text">
            Formatos aceitos: JPG, PNG, GIF, WEBP (até 5MB) ou MP4, MOV, AVI, WEBM (até 20MB)
          </div>
          <?php if ($editing_post && $editing_post['media']): ?>
            <div class="mt-2">
              <small class="text-muted">Mídia atual:</small>
              <?php if ($editing_post['media_type'] === 'image'): ?>
                <img src="app/core/uploads/<?= htmlspecialchars($editing_post['media']) ?>" class="thumb ms-2" alt="Current media">
              <?php elseif ($editing_post['media_type'] === 'video'): ?>
                <video class="thumb ms-2" controls>
                  <source src="app/core/uploads/<?= htmlspecialchars($editing_post['media']) ?>" type="video/mp4">
                  Seu navegador não suporta a tag de vídeo.
                </video>
              <?php endif; ?>
            </div>
          <?php endif; ?>
        </div>
        <div class="col-12">
          <label class="form-label">Conteúdo</label>
          <textarea name="content" class="form-control" rows="5" required><?= $editing_post ? htmlspecialchars($editing_post['conteudo']) : '' ?></textarea>
        </div>
        <div class="col-12">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="destaque" id="destaque" value="1" <?= ($editing_post && $editing_post['destaque']) ? 'checked' : '' ?>>
            <label class="form-check-label" for="destaque"><i class="fas fa-star me-1 text-warning"></i> Definir como artigo em destaque</label>
          </div>
        </div>
      </div>
      <div class="text-end mt-4">
        <button type="submit" class="btn btn-primary px-4">
          <i class="fas fa-<?= $editing_post ? 'save' : 'paper-plane' ?> me-2"></i>
          <?= $editing_post ? 'Atualizar' : 'Publicar' ?>
        </button>
      </div>
    </form>
  </div>

  <!-- Lista de Artigos -->
  <div class="card p-4">
    <h5 class="fw-semibold mb-3">Artigos publicados</h5>
    <?php if (empty($posts)): ?>
      <p class="text-muted">Nenhum artigo publicado ainda.</p>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>Mídia</th>
              <th>Título</th>
              <th>Autor</th>
              <th>Status</th>
              <th>Tempo</th>
              <th>Data</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($posts as $post): ?>
              <tr>
                <td>
                  <?php if (!empty($post['media'])): ?>
                    <?php if ($post['media_type'] === 'image'): ?>
                      <img src="app/core/uploads/<?= htmlspecialchars($post['media']) ?>" class="thumb" alt="thumb">
                    <?php elseif ($post['media_type'] === 'video'): ?>
                      <div class="video-thumb-container">
                        <video class="video-thumb" muted>
                          <source src="app/core/uploads/<?= htmlspecialchars($post['media']) ?>" type="video/mp4">
                        </video>
                        <div class="video-play-icon">
                          <i class="fas fa-play"></i>
                        </div>
                      </div>
                    <?php endif; ?>
                  <?php else: ?>
                    <span class="text-muted">Sem mídia</span>
                  <?php endif; ?>
                </td>
                <td>
                  <?= htmlspecialchars($post['titulo']) ?>
                  <?php if ($post['destaque']): ?>
                    <br><span class="featured-badge"><i class="fas fa-star me-1"></i>Destaque</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($post['autor']) ?></td>
                <td>
                  <?php if ($post['destaque']): ?>
                    <span class="badge bg-warning text-dark">Em Destaque</span>
                  <?php else: ?>
                    <span class="badge bg-secondary">Normal</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($post['tempo_leitura']) ?></td>
                <td><?= date('d/m/Y', strtotime($post['data_criacao'])) ?></td>
                <td>
                  <div class="actions-container">
                    <a href="admin_blog.php?edit=<?= $post['id'] ?>" class="btn btn-sm btn-outline-primary btn-action"><i class="fas fa-edit me-1"></i><span>Editar</span></a>

                    <form method="POST" action="admin_blog.php" class="d-inline">
                        <input type="hidden" name="action" value="toggle_featured">
                        <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                        <button type="submit" class="btn btn-sm <?= $post['destaque'] ? 'btn-warning' : 'btn-outline-warning' ?> btn-action">
                            <i class="fas fa-star me-1"></i><span><?= $post['destaque'] ? 'Remover' : 'Destacar' ?></span>
                        </button>
                    </form>

                    <a href="admin_blog.php?action=delete&id=<?= $post['id'] ?>" class="btn btn-sm btn-outline-danger btn-action" onclick="return confirm('Tem certeza que deseja excluir este artigo?')">
                        <i class="fas fa-trash me-1"></i><span>Excluir</span>
                    </a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>

<script>
// Media validation
document.getElementById('mediaInput').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;
    
    const imageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    const videoTypes = ['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/webm'];
    const maxImageSize = 5 * 1024 * 1024; // 5MB
    const maxVideoSize = 20 * 1024 * 1024; // 20MB
    
    if (!imageTypes.includes(file.type) && !videoTypes.includes(file.type)) {
        alert('Por favor, selecione uma imagem (JPG, PNG, GIF, WEBP) ou vídeo (MP4, MOV, AVI, WEBM).');
        this.value = '';
    } else if (imageTypes.includes(file.type) && file.size > maxImageSize) {
        alert('A imagem deve ter no máximo 5MB.');
        this.value = '';
    } else if (videoTypes.includes(file.type) && file.size > maxVideoSize) {
        alert('O vídeo deve ter no máximo 20MB.');
        this.value = '';
    }
});

// Video thumb hover effect
document.addEventListener('DOMContentLoaded', function() {
    const videoThumbs = document.querySelectorAll('.video-thumb');
    videoThumbs.forEach(function(video) {
        video.addEventListener('mouseenter', function() {
            this.play();
        });
        video.addEventListener('mouseleave', function() {
            this.pause();
            this.currentTime = 0;
        });
    });
});

// Auto-dismiss alerts after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>