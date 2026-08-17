<?php
require_once __DIR__ . "/../core/blog_functions.php";

// Base URL (adjust if your root folder name changes)
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($baseUrl === '' || $baseUrl === '.') {
    $baseUrl = '';
}
$baseUrl .= '/';

// Get id or slug from URL
$id = $_GET['id'] ?? null;
$slug = $_GET['slug'] ?? null;
$post = null;

// 1️⃣ If there's an ID, fetch directly
if ($id) {
    $post = getPostById((int)$id);
}

// 2️⃣ If not found, or no ID (user visited /post/slug)
if (!$post && $slug) {
    $all = getAllPosts();
    foreach ($all as $row) {
        // compare slugified title with the given slug
        $candidateSlug = slugify($row['titulo']);
        $candidateSlugId = $candidateSlug . '-' . $row['id'];

        if ($slug === $candidateSlug || $slug === $candidateSlugId) {
            $post = $row;
            break;
        }
    }
}

// 3️⃣ If still not found, show error
if (!$post) {
    http_response_code(404);
    die("Post não encontrado.");
}

// 4️⃣ Continue rendering the page
ob_start();
?>

<head>
  <link rel="stylesheet" href="<?= $baseUrl ?>public/css/post.css">
</head>
<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-8">
        
        <!-- Post Header -->
        <div class="post-header text-center mb-4">
          <h1 class="post-title display-5 fw-bold mb-4" style="font-size:2.5rem">
            <?= htmlspecialchars($post['titulo']) ?>
          </h1>
          
          <div class="post-meta d-flex flex-wrap justify-content-center align-items-center gap-4 text-muted mb-4">
            <div class="author">
              <i class="fas fa-user me-2"></i>
              <span class="fw-medium"><?= htmlspecialchars($post['autor'] ?? 'Equipe OdontoCare') ?></span>
            </div>
            <div class="date">
              <i class="fas fa-calendar me-2"></i>
              <?= date('d/m/Y', strtotime($post['data_criacao'])) ?>
            </div>
            <div class="reading-time">
              <i class="fas fa-clock me-2"></i>
              <?= htmlspecialchars($post['tempo_leitura'] ?? '5 min') ?> de leitura
            </div>
            <?php if ($post['media_type'] === 'video'): ?>
              <div class="media-type-badge">
                <span class="badge bg-primary">
                  <i class="fas fa-video me-1"></i>Contém vídeo
                </span>
              </div>
            <?php endif; ?>
          </div>
        </div>

        <!-- Featured Media -->
        <?php if (!empty($post['media'])): ?>
          <div class="post-featured-media mb-5">
            <?php if ($post['media_type'] === 'video'): ?>
              <div class="video-container rounded-3 shadow overflow-hidden">
                <video controls class="w-100" style="max-height: 500px;">
                  <source src="<?= $baseUrl ?>app/core/uploads/<?= htmlspecialchars($post['media']) ?>" type="video/mp4">
                  Seu navegador não suporta o elemento de vídeo.
                </video>
              </div>
            <?php else: ?>
              <div class="image-container">
                <img src="<?= $baseUrl ?>app/core/uploads/<?= htmlspecialchars($post['media']) ?>" 
                     class="img-fluid rounded-3 shadow" 
                     alt="<?= htmlspecialchars($post['titulo']) ?>">
              </div>
            <?php endif; ?>
          </div>
        <?php else: ?>
          <div class="post-featured-image mb-5">
            <img src="<?= $baseUrl ?>public/img/imagem-padrao.jpg" 
                 class="img-fluid rounded-3 shadow" 
                 alt="Imagem padrão">
          </div>
        <?php endif; ?>

        <!-- Post Content -->
        <article class="post-content">
          <div class="content-wrapper">
            <div class="content fs-5 lh-lg">
              <?= nl2br(htmlspecialchars($post['conteudo'])) ?>
            </div>
          </div>
        </article>

        <!-- Post Footer -->
        <div class="post-footer mt-5 pt-5 border-top">
          <div class="row align-items-center">
            <div class="col-md-6">
              <a href="<?= $baseUrl ?>blog" class="btn btn-primary">
                <i class="fas fa-arrow-left me-2"></i>Voltar ao Blog
              </a>
            </div>
            <div class="col-md-6 text-md-end">
              <div class="social-share">
                <span class="text-muted me-3">Compartilhar:</span>
                <a href="#" class="btn btn-sm btn-outline-primary me-2">
                  <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="btn btn-sm btn-outline-primary me-2">
                  <i class="fab fa-whatsapp"></i>
                </a>
                <a href="#" class="btn btn-sm btn-outline-primary">
                  <i class="fas fa-link"></i>
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<?php
$page_content = ob_get_clean();
$page_title = htmlspecialchars($post['titulo']) . " | Blog OdontoCare";
include "layout.php";
?>