<?php
require_once __DIR__ . "/../core/blog_functions.php";

// Pega o post em destaque e os posts regulares
$featured = getFeaturedPost();
$regularPosts = getRegularPosts();

// Define o caminho base (ajuste se a pasta principal tiver outro nome)
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($baseUrl === '' || $baseUrl === '.') {
    $baseUrl = '';
}
$baseUrl .= '/';

// Começa a capturar o conteúdo da página
ob_start();
?>

<section class="py-5">
  <div class="container">
    <!-- Header Section -->
    <div class="text-center mb-5">
      <h1 class="fw-bold display-6 mb-3 section-title">Blog OdontoCare</h1>
      <p class="lead text-muted mx-auto mb-5" style="max-width: 600px;">
        Descubra artigos especializados sobre saúde bucal, tratamentos inovadores e dicas para manter seu sorriso saudável
      </p>
    </div>

    <?php if (!$featured && empty($regularPosts)): ?>
      <div class="text-center py-5 my-5">
        <div class="empty-state">
          <i class="fas fa-edit fa-4x mb-4"></i>
          <h3 class="text-muted mb-3">Em breve novidades!</h3>
          <p class="text-muted">Estamos preparando conteúdo especializado para você.</p>
        </div>
      </div>
    <?php else: ?>

      <!-- Featured Post -->
      <?php if ($featured): ?>
        <?php 
          $featuredSlug = slugify($featured['titulo']);
          $featuredUrl  = "{$baseUrl}post/{$featuredSlug}-{$featured['id']}";
        ?>
        <div class="featured-post mb-5">
          <div class="row g-4 align-items-center">
            <div class="col-lg-6">
              <div class="featured-image position-relative rounded-3 overflow-hidden">
                <?php if (!empty($featured['media'])): ?>
                  <?php if ($featured['media_type'] === 'video'): ?>
                    <video class="img-fluid" controls poster="<?= $baseUrl ?>public/img/video-poster.jpg">
                      <source src="<?= $baseUrl ?>app/core/uploads/<?= htmlspecialchars($featured['media']) ?>" type="video/mp4">
                      Seu navegador não suporta o elemento de vídeo.
                    </video>
                  <?php else: ?>
                    <img src="<?= $baseUrl ?>app/core/uploads/<?= htmlspecialchars($featured['media']) ?>" class="img-fluid" alt="<?= htmlspecialchars($featured['titulo']) ?>">
                  <?php endif; ?>
                <?php else: ?>
                  <img src="<?= $baseUrl ?>public/img/imagem-padrao.jpg" class="img-fluid" alt="Imagem padrão">
                <?php endif; ?>
                <div class="featured-badge">
                  <i class="fas fa-star me-1"></i>Destaque
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="featured-content p-4">
                <div class="post-meta mb-3">
                  <span class="badge me-2">Artigo em Destaque</span>
                  <span class="text-muted">
                    <?= date('d/m/Y', strtotime($featured['data_criacao'])) ?>
                  </span>
                </div>
                <h2 class="featured-title mb-3">
                  <a href="<?= htmlspecialchars($featuredUrl) ?>" class="text-decoration-none">
                    <?= htmlspecialchars($featured['titulo']) ?>
                  </a>
                </h2>
                <p class="featured-excerpt text-muted mb-4">
                  <?= strlen($featured['conteudo']) > 200 ? substr($featured['conteudo'], 0, 200) . '...' : $featured['conteudo'] ?>
                </p>
                <div class="post-info d-flex align-items-center justify-content-between">
                  <div class="author-info">
                    <span class="text-muted fw-medium">
                      <i class="fas fa-user me-1"></i>
                      <?= htmlspecialchars($featured['autor'] ?? 'Equipe OdontoCare') ?>
                    </span>
                  </div>
                  <div class="read-time">
                    <span class="text-muted">
                      <i class="fas fa-clock me-1"></i>
                      <?= htmlspecialchars($featured['tempo_leitura'] ?? '5 min') ?>
                    </span>
                  </div>
                </div>
                <a href="<?= htmlspecialchars($featuredUrl) ?>" class="btn btn-primary mt-4">
                  Ler Artigo Completo <i class="fas fa-arrow-right ms-2"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Regular Posts Grid -->
      <?php if (!empty($regularPosts)): ?>
        <div class="posts-grid">
          <h3 class="section-subtitle mb-4">Mais Artigos</h3>
          <div class="row g-4">
            <?php foreach ($regularPosts as $post): ?>
              <?php 
                $slug = slugify($post['titulo']);
                $url  = "{$baseUrl}post/{$slug}-{$post['id']}";
              ?>
              <div class="col-lg-6">
                <div class="post-card card border-0 shadow-sm h-100">
                  <div class="card-img-top position-relative">
                    <?php if (!empty($post['media'])): ?>
                      <?php if ($post['media_type'] === 'video'): ?>
                        <div class="video-thumb-container">
                          <video class="card-img-top video-thumb" muted>
                            <source src="<?= $baseUrl ?>app/core/uploads/<?= htmlspecialchars($post['media']) ?>" type="video/mp4">
                          </video>
                          <div class="video-play-icon">
                            <i class="fas fa-play"></i>
                          </div>
                          <div class="video-badge">
                            <i class="fas fa-video me-1"></i>Vídeo
                          </div>
                        </div>
                      <?php else: ?>
                        <img src="<?= $baseUrl ?>app/core/uploads/<?= htmlspecialchars($post['media']) ?>" class="card-img-top" alt="<?= htmlspecialchars($post['titulo']) ?>">
                      <?php endif; ?>
                    <?php else: ?>
                      <img src="<?= $baseUrl ?>public/img/imagem-padrao.jpg" class="card-img-top" alt="Imagem padrão">
                    <?php endif; ?>
                    <div class="card-overlay"></div>
                  </div>
                  <div class="card-body p-4">
                    <div class="post-meta mb-2">
                      <small class="text-muted">
                        <i class="fas fa-calendar me-1"></i>
                        <?= date('d/m/Y', strtotime($post['data_criacao'])) ?>
                      </small>
                    </div>
                    <h4 class="post-title mb-3">
                      <a href="<?= htmlspecialchars($url) ?>" class="text-decoration-none">
                        <?= htmlspecialchars($post['titulo']) ?>
                      </a>
                    </h4>
                    <p class="post-excerpt text-muted mb-3">
                      <?= strlen($post['conteudo']) > 150 ? substr($post['conteudo'], 0, 150) . '...' : $post['conteudo'] ?>
                    </p>
                    <div class="post-footer d-flex align-items-center justify-content-between">
                      <span class="text-muted small">
                        <i class="fas fa-user me-1"></i>
                        <?= htmlspecialchars($post['autor'] ?? 'Equipe OdontoCare') ?>
                      </span>
                      <a href="<?= htmlspecialchars($url) ?>" class="btn btn-sm btn-outline-primary">
                        Ler mais
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endif; ?>

    <?php endif; ?>
  </div>
</section>

<script>
// Auto-play video thumbnails on hover
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
    
    // Click to go to post page
    video.closest('.video-thumb-container').addEventListener('click', function(e) {
      if (e.target.classList.contains('video-thumb') || e.target.classList.contains('video-play-icon')) {
        const link = this.closest('.post-card').querySelector('.post-title a');
        if (link) {
          window.location.href = link.href;
        }
      }
    });
  });
});
</script>

<?php
$page_content = ob_get_clean();
$page_title = "Blog | OdontoCare";
include "layout.php";
?>