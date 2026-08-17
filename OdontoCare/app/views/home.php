<?php
// index.php
require_once __DIR__ . "/../core/blog_functions.php";

// Get the latest 3 posts for the homepage
$latestPosts = getLatestPosts(3);

$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($baseUrl === '' || $baseUrl === '.') {
    $baseUrl = '';
}
$baseUrl .= '/';

// Começamos a capturar o conteúdo da página
ob_start();
?>

<!-- Hero Section -->
<section class="hero">
  <picture>
    <!-- Mobile image -->
    <source 
      srcset="<?= $baseUrl ?>public/img/hero1.jpg" 
      media="(max-width: 768px)">

    <!-- Desktop image -->
    <img 
      src="<?= $baseUrl ?>public/img/hero1.jpg" 
      alt="OdontoCare Hero" 
      class="hero-bg"
      loading="eager"
      fetchpriority="high"
      decoding="async">
  </picture>

  <div class="container">
    <div class="hero-content">
      <h1 class="mb-3"> 
        Sorria para a vida<br>
        com a <span class="logo-text">Odonto<span class="logo-green">Care</span></span>
      </h1>
    </div>
  </div>
</section>


<!-- Serviços -->
<section id="servicos" class="py-5">
  <div class="container">
    <h2 class="text-center fw-bold section-title">Nossos Serviços</h2>
    <p class="text-center text-muted mb-5">Oferecemos tratamentos odontológicos completos para toda a família</p>

    <!-- Serviços com expansão vertical -->
    <div class="services-accordion">
      <!-- Implantes Dentários -->
      <div class="service-item">
        <button class="service-header" onclick="toggleService(1)">
          <h3>Implantes Dentários</h3>
          <span class="service-icon">+</span>
        </button>
        <div class="service-content" id="service-1">
          <p>Devolva a função e a beleza do seu sorriso. Utilizamos pinos de titânio de alta tecnologia para substituir dentes perdidos, garantindo resultados naturais, seguros e duradouros que parecem e funcionam como dentes reais.</p>
        </div>
      </div>

      <!-- OOrtodontia e Alinhadores Invisíveis -->
      <div class="service-item">
        <button class="service-header" onclick="toggleService(2)">
          <h3>Ortodontia e Alinhadores Invisíveis</h3>
          <span class="service-icon">+</span>
        </button>
        <div class="service-content" id="service-2">
          <p>Corrija o alinhamento dos seus dentes com conforto e estética. Oferecemos desde os tradicionais aparelhos estéticos até os modernos alinhadores transparentes (invisíveis), para um tratamento rápido e super discreto.</p>
        </div>
      </div>

      <!-- Lentes de Contato Dental -->
      <div class="service-item">
        <button class="service-header" onclick="toggleService(3)">
          <h3>Lentes de Contato Dental</h3>
          <span class="service-icon">+</span>
        </button>
        <div class="service-content" id="service-3">
          <p>Transforme seu sorriso em poucas sessões. As lentes são lâminas ultrafinas de porcelana aplicadas sobre os dentes para corrigir formato, tamanho, cor e pequenos desgastes, criando uma estética impecável e harmoniosa.</p>
        </div>
      </div>

      <!-- Clareamento Dental -->
      <div class="service-item">
        <button class="service-header" onclick="toggleService(4)">
          <h3>Clareamento Dental</h3>
          <span class="service-icon">+</span>
        </button>
        <div class="service-content" id="service-4">
          <p>Transforme seu sorriso em poucas sessões. As lentes são lâminas ultrafinas de porcelana aplicadas sobre os dentes para corrigir formato, tamanho, cor e pequenos desgastes, criando uma estética impecável e harmoniosa.</p>
        </div>
      </div>

      <!-- Clínica Geral e Prevenção -->
      <div class="service-item">
        <button class="service-header" onclick="toggleService(5)">
          <h3>Clínica Geral e Prevenção</h3>
          <span class="service-icon">+</span>
        </button>
        <div class="service-content" id="service-5">
          <p>A base para uma boca saudável. Realizamos check-ups regulares, profilaxia (limpeza profissional) e remoção de tártaro para prevenir cáries e inflamações, garantindo que sua saúde bucal esteja sempre em dia.</p>
        </div>
      </div>
    </div>

    <div class="text-center mt-4">
      <a href="servicos.php" class="btn btn-primary">Ver todos os serviços</a>
    </div>
  </div>
</section>

<!-- Programa de Assistência -->
<section id="programa" class="program-section bg-light">
  <div class="container text-center">
    <h2 class="section-title">Programa de Assistência</h2>
    <p class="section-subtitle">Saúde bucal completa para famílias</p>

    <div class="program-card">
      <div class="program-icon">
        <i class="fas fa-heart"></i>
      </div>
      <h3 class="program-title">Programa de Assistência Familiar</h3>
      <p class="program-description">
        Na OdontoCare, sabemos que ver a sua família sorrir é o que mais importa. Por isso, criamos o Programa de Assistência Familiar, uma iniciativa pensada para facilitar o acesso de quem você ama a tratamentos odontológicos de excelência. Com vantagens exclusivas, condições flexíveis e foco na prevenção, garantimos que todas as gerações – das crianças aos avós – recebam um cuidado contínuo e humanizado. Nosso objetivo é construir um histórico de saúde bucal sólido para a sua família, proporcionando tranquilidade e bem-estar. Venha proteger o sorriso de quem você mais ama!
      </p>
    </div>
  </div>
</section>

<!-- Blog -->
<section id="blog" class="py-5">
  <div class="container">
    <h2 class="text-center fw-bold section-title">Blog OdontoCare</h2>
    <p class="text-center text-muted mb-5">Dicas e informações sobre saúde bucal</p>

    <?php if (empty($latestPosts)): ?>
      <div class="text-center py-4">
        <p class="text-muted">Em breve teremos novidades no nosso blog!</p>
        <a href="<?= $baseUrl ?>blog" class="btn btn-outline-primary">Visite nosso Blog</a>
      </div>
    <?php else: ?>
      <div class="row g-4">
        <?php foreach ($latestPosts as $post): ?>
          <div class="col-md-4">
            <div class="blog-card">
              <div class="blog-image">
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
                  <img src="<?= $baseUrl ?>public/img/imagem-padrao.jpg" class="img-fluid" alt="Imagem padrão">
                <?php endif; ?>
                <div class="blog-date">
                  <span><?= date('d', strtotime($post['data_criacao'])) ?></span>
                  <span><?= strtoupper(date('M', strtotime($post['data_criacao']))) ?></span>
                </div>
              </div>
              <div class="card-body">
                <h5 class="fw-bold"><?= htmlspecialchars($post['titulo']) ?></h5>
                <p class="text-muted">
                  <?= strlen($post['conteudo']) > 100 ? substr($post['conteudo'], 0, 100) . '...' : $post['conteudo'] ?>
                </p>
                <div class="d-flex justify-content-between align-items-center">
                  <small class="text-muted">
                    <i class="fas fa-user me-1"></i>
                    <?= htmlspecialchars($post['autor'] ?? 'Equipe OdontoCare') ?>
                  </small>
                  <a href="<?= $baseUrl ?>post/<?= slugify($post['titulo']) ?>-<?= $post['id'] ?>" class="btn btn-outline-primary btn-sm">Leia mais</a>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <div class="text-center mt-4">
        <a href="<?= $baseUrl ?>blog" class="btn btn-primary">Visite nosso Blog</a>
      </div>
    <?php endif; ?>
  </div>
</section>


<script>
function toggleService(serviceId) {
  const item = document.getElementById(`service-${serviceId}`).parentElement;
  const icon = item.querySelector('.service-icon');

  item.classList.toggle('active');
  icon.textContent = item.classList.contains('active') ? '-' : '+';
}
</script>

<?php
// Finaliza o conteúdo e passa para o layout
$page_content = ob_get_clean();
$page_title = "OdontoCare | Clínica Odontológica";

// Inclui o layout
include "layout.php";
?>