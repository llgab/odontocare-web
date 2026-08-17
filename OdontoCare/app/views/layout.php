<?php
// Detect base URL automatically (works for localhost and hosting)
$baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
if ($baseUrl === '' || $baseUrl === '.') $baseUrl = '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <!-- Basic Metadata -->
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $page_title ?? "OdontoCare | Clínica Odontológica" ?></title>
  <meta name="description" content="<?= $page_description ?? 'Clínica OdontoCare - tratamentos odontológicos com qualidade e cuidado.' ?>">
  <meta name="keywords" content="OdontoCare, odontologia, dentista, clínica odontológica, saúde bucal">
  <meta name="author" content="OdontoCare">

  <!-- Open Graph (Social Sharing) -->
  <meta property="og:title" content="<?= $page_title ?? 'OdontoCare | Clínica Odontológica' ?>">
  <meta property="og:description" content="<?= $page_description ?? 'Tratamentos odontológicos com excelência e tecnologia.' ?>">
  <meta property="og:image" content="<?= $baseUrl ?>/public/img/og-image.png">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?= 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">

  <!-- Favicon & App Icons -->
  <link rel="icon" type="image/png" href="<?= $baseUrl ?>/public/img/favicon/favicon-96x96.png" sizes="96x96">
  <link rel="icon" type="image/svg+xml" href="<?= $baseUrl ?>/public/img/favicon/favicon.svg">
  <link rel="shortcut icon" href="<?= $baseUrl ?>/public/img/favicon/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="<?= $baseUrl ?>/public/img/favicon/apple-touch-icon.png">
  <meta name="apple-mobile-web-app-title" content="OdontoCare">
  <link rel="manifest" href="<?= $baseUrl ?>/public/img/favicon/site.webmanifest">

  <!-- ⚡ Performance Optimizations -->

  <!-- Preconnect for faster DNS/TLS -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

  <!-- Google Fonts (Preload + non-blocking load) -->
  <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap"
        onload="this.rel='stylesheet'">
  <noscript>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700;800&display=swap">
  </noscript>

  <!-- Bootstrap (non-blocking) -->
  <link rel="preload" as="style"
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        onload="this.rel='stylesheet'">
  <noscript>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  </noscript>

  <!-- Font Awesome (non-blocking) -->
  <link rel="preload" as="style"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        onload="this.rel='stylesheet'">
  <noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  </noscript>

  <!-- Preload key hero images -->
  <link rel="preload" as="image" href="<?= $baseUrl ?>/public/img/hero1.jpg" fetchpriority="high">
  <link rel="preload" as="image" href="<?= $baseUrl ?>/public/img/hero1.jpg" fetchpriority="high">
  <link rel="preload" as="image" href="<?= $baseUrl ?>/public/img/hero2.jpg" fetchpriority="high">
  <link rel="preload" as="image" href="<?= $baseUrl ?>/public/img/hero2.jpg" fetchpriority="high">

  <!-- Local CSS (non-blocking) -->
  <link rel="preload" href="<?= $baseUrl ?>/public/css/layout.css" as="style" onload="this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="<?= $baseUrl ?>/public/css/layout.css"></noscript>

  <?php if (!empty($page_css)): ?>
    <link rel="preload" href="<?= $baseUrl ?>/public/css/<?= htmlspecialchars($page_css) ?>.css"
          as="style" onload="this.rel='stylesheet'">
    <noscript>
      <link rel="stylesheet" href="<?= $baseUrl ?>/public/css/<?= htmlspecialchars($page_css) ?>.css">
    </noscript>
  <?php endif; ?>

  <meta name="robots" content="index, follow">
  <meta name="language" content="Portuguese">

  <?php
  // Always include layout.css
  echo '<link rel="stylesheet" href="' . $baseUrl . '/public/css/layout.css">';

  // Detect current path
  $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
  $uri = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $uri);
  $parts = explode('/', $uri);

  // Default to home
  $page_name = 'home';

  // If URL starts with 'post', load post.css
  if (isset($parts[1]) && $parts[1] === 'post') {
      $page_name = 'post';
  } elseif (isset($parts[0]) && $parts[0] === 'post') {
      $page_name = 'post';
  } elseif (!empty($parts[0])) {
      // Otherwise, get last segment (e.g. /servicos)
      $page_name = preg_replace('/\.php$/', '', end($parts));
  }

  // Build path
  $css_path = $_SERVER['DOCUMENT_ROOT'] . $baseUrl . '/public/css/' . $page_name . '.css';
  $css_url  = $baseUrl . '/public/css/' . $page_name . '.css';

  // Load specific CSS if it exists, else home.css
  if (file_exists($css_path)) {
      echo '<link rel="stylesheet" href="' . $css_url . '">';
  } else {
      echo '<link rel="stylesheet" href="' . $baseUrl . '/public/css/home.css">';
  }

  ?>
</head>
<body>

<a href="https://wa.me/9999999999999"
   class="whatsapp-float"
   target="_blank"
   aria-label="Conversar pelo WhatsApp">
  <i class="fab fa-whatsapp"></i>
</a>

<header class="py-2">
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="<?= $baseUrl ?>/home">
          <img src="<?= $baseUrl ?>/public/img/logo.png" alt="OdontoCare" height="50">
        </a>
        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
                aria-controls="navbarNav"
                aria-expanded="false"
                aria-label="Abrir menu de navegação">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/home">Início</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/servicos">Serviços</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/blog">Blog</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/sobre">Sobre Nós</a></li>
            <li class="nav-item"><a class="nav-link" href="<?= $baseUrl ?>/contato">Contato</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</header>

<main>
  <?= $page_content ?? "" ?>
</main>

<footer id="contato">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-4">
        <img src="<?= $baseUrl ?>/public/img/logo.png" alt="OdontoCare" height="50"><br><br>
        <div class="social-icons">
          <a href="https://www.facebook.com/odonto_care_fake/?locale=pt_BR"
            target="_blank"
            aria-label="Facebook da OdontoCare">
            <i class="fab fa-facebook-f"></i>
          </a>

          <a href="https://www.instagram.com/odonto_care_fake/?hl=en"
            target="_blank"
            aria-label="Instagram da OdontoCare">
            <i class="fab fa-instagram"></i>
          </a>

          <a href="https://wa.me/9999999999999"
            target="_blank"
            aria-label="WhatsApp da OdontoCare">
            <i class="fab fa-whatsapp"></i>
          </a>

          <a href="https://linkr.bio/OdontoCareFake"
            target="_blank"
            aria-label="Linktree da OdontoCare">
            <i class="fas fa-link"></i>
          </a>
        </div>
      </div>

      <div class="col-md-2 mb-4">
        <h5 class="fw-bold mb-3">Links Rápidos</h5>
        <div class="footer-links">
          <a href="<?= $baseUrl ?>/home">Início</a>
          <a href="<?= $baseUrl ?>/servicos">Serviços</a>
          <a href="<?= $baseUrl ?>/blog">Blog</a>
          <a href="<?= $baseUrl ?>/sobre">Sobre Nós</a>
          <a href="<?= $baseUrl ?>/contato">Contato</a>
        </div>
      </div>

      <div class="col-md-3 mb-4">
        <h5 class="fw-bold mb-3">Contato</h5>
        <p><i class="fas fa-map-marker-alt me-2"></i>Avenida Primavera, 1024 - Sala 402 - Centro -  Barbacena - MG</p>
        <p><i class="fas fa-envelope me-2"></i>OdontoCareFake@gmail.com</p>
        <p><i class="fas fa-phone me-2"></i>(99) 9999-9999</p>
        <p><i class="fas fa-phone me-2"></i>(99) 9999-9999</p>
      </div>

      <div class="col-md-3 mb-4">
        <h5 class="fw-bold mb-3">Horário de Funcionamento</h5>
        <p><strong>Segunda a Sexta:</strong><br> 8h às 12h e <br>13:30h às 18:30h</p>
        <p><strong>Sábado:</strong> 8h às 12h</p>
        <p><strong>Domingo:</strong> Fechado</p>
      </div>
    </div>

    <div class="copyright text-center">
      <p>© <?= date('Y') ?> OdontoCare. Todos os direitos reservados.</p>
    </div>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
