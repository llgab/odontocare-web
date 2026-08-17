<?php
// app/views/errors/404.php
ob_start();
http_response_code(404);
?>

<head>
<style>
    .error-404 {
    background: linear-gradient(135deg, #f8f9fa 0%, var(--primary-light) 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    }

    /* Error Illustration */
    .error-illustration {
    position: relative;
    margin-bottom: 3rem;
    }

    .error-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 2;
    }

    .error-icon i {
    font-size: 3rem;
    color: var(--secondary);
    margin: 0 10px;
    opacity: 0.8;
    animation: float 3s ease-in-out infinite;
    }

    .error-icon i:nth-child(2) {
    animation-delay: 0.5s;
    }

    .error-icon i:nth-child(3) {
    animation-delay: 1s;
    }

    .error-number {
    font-size: 8rem;
    font-weight: 900;
    color: var(--primary);
    position: relative;
    z-index: 1;
    opacity: 0.1;
    }

    .number-4, .number-0 {
    display: inline-block;
    animation: bounce 2s ease-in-out infinite;
    }

    .number-0 {
    animation-delay: 0.3s;
    }

    .number-4:last-child {
    animation-delay: 0.6s;
    }

    /* Error Content */
    .error-title {
    color: var(--primary);
    font-size: 2.5rem;
    }

    .error-description {
    font-size: 1.2rem;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    }

    /* Animations */
    @keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
    }

    @keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
    }

    /* ===== RESPONSIVE STYLES ===== */

    /* TABLET (max-width: 1024px) */
    @media (max-width: 1024px) {
    .error-number {
        font-size: 6rem;
    }
    
    .error-title {
        font-size: 2.2rem;
    }
    
    .error-description {
        font-size: 1.1rem;
    }
    }

    /* MOBILE (max-width: 768px) */
    @media (max-width: 768px) {
    .error-404 {
        padding: 2rem 0;
    }
    
    .error-number {
        font-size: 4rem;
    }
    
    .error-title {
        font-size: 1.8rem;
    }
    
    .error-description {
        font-size: 1rem;
    }
    
    .error-icon i {
        font-size: 2rem;
        margin: 0 5px;
    }
    }

    /* SMALL MOBILE (max-width: 480px) */
    @media (max-width: 480px) {
    .error-number {
        font-size: 3rem;
    }
    
    .error-title {
        font-size: 1.6rem;
    }
    
    .error-icon i {
        font-size: 1.5rem;
    }
    
    .action-icon {
        font-size: 2rem;
    }
    }
</style>
</head>

<section class="error-404 py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center">
        <div class="error-illustration mb-5">
          <div class="error-icon">
            <i class="fas fa-tooth"></i>
            <i class="fas fa-map-signs"></i>
          </div>
          <div class="error-number">
            <span class="number-4">4</span>
            <span class="number-0">0</span>
            <span class="number-4">4</span>
          </div>
        </div>

        <div class="error-content">
          <h1 class="error-title fw-bold mb-4">Página Não Encontrada</h1>
          <p class="error-description lead text-muted mb-5">
            Ops! Parece que o sorriso que você está procurando não está aqui. 
            A página que você tentou acessar não foi encontrada em nossa clínica virtual.
          </p>

        <a href="?url=home" class="btn btn-primary btn-sm">Voltar ao Início</a>

        </div>
      </div>
    </div>
  </div>
</section>

<?php
$page_content = ob_get_clean();
$page_title = "Página Não Encontrada | OdontoCare";

// include layout relative to this file:
include __DIR__ . '/../layout.php';
