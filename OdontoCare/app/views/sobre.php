<?php
require_once __DIR__ . "/../core/blog_functions.php";
$posts = getAllPosts();

// Monta o conteúdo da página em uma variável
ob_start();
?>

<!-- Hero Section with Clinic Photo -->
<section class="hero">
  <picture>
    <!-- Mobile image -->
    <source srcset="<?= $baseUrl ?>public/img/hero2.jpg" media="(max-width: 768px)">
    <!-- Desktop image -->
    <img 
      src="<?= $baseUrl ?>public/img/hero2.jpg" 
      alt="Clínica OdontoCare" 
      class="hero-bg" 
      loading="eager" 
      fetchpriority="high"
    >
  </picture>

  <div class="container">
    <div class="hero-content">
      <h1 class="mb-3">Sobre Nós</h1>
    </div>
  </div>
</section>

<!-- About Section -->
<section id="sobre" class="sobre py-5 bg-white">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10 col-xl-8">
        <div class="section-header text-center mb-5">
          <span class="section-subtitle">SOBRE NÓS</span>
          <h2 class="section-title fw-bold mb-4">A OdontoCare</h2>
        </div>
        <div class="about-content text-center">
          <p class="mb-4 fs-5">
            Na OdontoCare, acreditamos que um sorriso saudável é o reflexo da sua qualidade de vida. Fundada com a missão de inovar na odontologia, nossa clínica une tecnologia de ponta a um atendimento genuinamente humano e acolhedor. Nossa equipe de especialistas se dedica a garantir que cada paciente se sinta ouvido, seguro e confortável. Como cada pessoa é única, criamos planos de tratamento totalmente personalizados.
          </p>
          <p class="mb-4 fs-5">
            Para entregar excelência, investimos continuamente em infraestrutura moderna e na atualização dos nossos profissionais. Nosso espaço foi projetado para ser um ambiente relaxante, eliminando qualquer ansiedade na ida ao dentista. Utilizamos técnicas minimamente invasivas que priorizam a sua saúde a longo prazo. Mais do que realizar procedimentos, nosso grande compromisso é construir uma relação de confiança com você.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Values Section -->
<section class="valores py-5 bg-light">
  <div class="container">
    <div class="section-header text-center mb-5">
      <span class="section-subtitle">NOSSA FILOSOFIA</span>
      <h2 class="section-title fw-bold mb-5">Valores que nos guiam</h2>
    </div>
    <div class="row g-4">
      <div class="col-md-12">
        <div class="card border-0 shadow-sm h-100 text-center p-4 value-card">
          <div class="icon-wrapper bg-primary bg-opacity-10 rounded-circle mx-auto mb-4 d-flex align-items-center justify-content-center">
            <!-- Mission Icon -->
            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
              <path d="M9 12l2 2 4-4"/>
            </svg>
          </div>
          <h5 class="fw-bold">MISSÃO</h5>
          <p class="text-muted">Nossa missão é transformar a experiência odontológica através de um atendimento humanizado e focado no bem-estar integral de cada paciente. Acreditamos que a saúde bucal é a base para uma vida feliz e confiante. Nosso compromisso é oferecer tratamentos de excelência, unindo tecnologia de ponta, técnicas modernas e uma equipe de especialistas dedicados. Queremos desmistificar o medo do dentista, proporcionando um ambiente acolhedor e seguro, onde todos são tratados com absoluto respeito e transparência. Mais do que cuidar de dentes, nossa missão maior é construir sorrisos duradouros e relações de confiança que acompanhem nossos pacientes ao longo da vida.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Team Section -->
<section class="equipe py-5 bg-white">
  <div class="container">
    <div class="section-header text-center mb-5">
      <span class="section-subtitle">PROFISSIONAIS</span>
      <h2 class="section-title fw-bold mb-5">Nossa Equipe</h2>
      <p class="text-muted mx-auto" style="max-width: 600px;">Contamos com uma equipe multidisciplinar de profissionais qualificados, apaixonados pela odontologia e comprometidos com seu sorriso.</p>
    </div>
    
<!-- Main Dentist/Owner Section -->
<div class="main-dentist mb-5">
  <div class="text-center mb-4">
    <span class="section-subtitle">GESTORA</span>
    <h3 class="fw-bold mb-2">Dra. Maria Carvalho</h3>
    <p class="dentist-specialty">
      Implantodontia, Periodontia, Odontologia Estética e Harmonização Orofacial
    </p>
  </div>

  <div class="row align-items-center justify-content-center">
    <!-- Photo (Left) -->
    <div class="col-lg-5 col-md-6 text-center mb-4 mb-md-0">
      <img
        src="public/img/maria.jpg"
        alt="Dra. Maria Carvalho - Gestora"
        class="img-fluid rounded-3 shadow-lg owner-photo"
      >
    </div>

    <!-- Text (Right) -->
    <div class="col-lg-6 col-md-10">
      <div class="dentist-info">
        <p class="mb-4 lead">
          A Dra. Maria Carvalho é graduada em Odontologia desde 2005 e possui uma trajetória marcada pela excelência clínica e constante atualização. É especialista em Implantodontia, Harmonização Orofacial e Periodontia, além de possuir título de Mestre em Clínica Odontológica pela Universidade de Ciências Odontológicas (UCO).
        </p>
        <p class="mb-4 lead">
          Com mais de 15 anos de educação continuada, foi professora convidada em cursos de especialização de institutos renomados, como o Centro Sul-Americano de Reabilitação Oral, a Escola Superior de Saúde Odontológica e o Instituto Internacional de Estudos da Face.
        </p>
        <p class="mb-0 lead">
          É Coordenadora Regional do projeto social Sorrisos para o Futuro e exerce o cargo de Diretora Científica da Sociedade Nacional de Especialistas em Odontologia – Regional (Gestão 2024–2028).
        </p>
      </div>
    </div>
  </div>
</div>

    
    <!-- Other Team Members -->
    <div class="team-members">
      <h4 class="text-center fw-bold mb-5">Nossa Equipe de Especialistas</h4>
      <div class="row g-4 justify-content-center">
        <div class="col-md-6 col-lg-3">
          <div class="team-member-card text-center p-4 rounded-3 shadow-sm border-0 h-100">
            <h5 class="fw-bold mb-2">Dr. Rafael Mendes</h5>
            <p class="member-specialty mb-3">Endodontia e Cirurgia Oral Menor</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
          <div class="team-member-card text-center p-4 rounded-3 shadow-sm border-0 h-100">
            <h5 class="fw-bold mb-2">Dra. Beatriz Novaes</h5>
            <p class="member-specialty mb-3">Cirurgias e Implantes</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
          <div class="team-member-card text-center p-4 rounded-3 shadow-sm border-0 h-100">
            <h5 class="fw-bold mb-2">Dra. Camila Rocha</h5>
            <p class="member-specialty mb-3">Cirurgias e Clínica-geral</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3">
          <div class="team-member-card text-center p-4 rounded-3 shadow-sm border-0 h-100">
            <h5 class="fw-bold mb-2">Dr. Thiago Viana</h5>
            <p class="member-specialty mb-3">Tratamento de canal</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Timeline Section -->
<section class="timeline py-5 bg-light">
  <div class="container">
    <div class="section-header text-center mb-5">
      <span class="section-subtitle">NOSSA TRAJETÓRIA</span>
      <h2 class="section-title fw-bold mb-5">Uma história de dedicação</h2>
      <p class="text-muted mx-auto" style="max-width: 600px;">Mais de 20 anos de compromisso com a excelência em odontologia e serviço à comunidade.</p>
    </div>
    
    <div class="sleek-timeline">
      <div class="timeline-line"></div>
      
      <!-- Timeline Item 1 - Left -->
      <div class="timeline-item left">
        <div class="timeline-content">
          <div class="timeline-year">2011</div>
          <h4 class="timeline-title">O Início de um Sonho</h4>
          <p class="timeline-description">A OdontoCare abriu suas portas com um pequeno consultório de duas salas. Desde o primeiro dia, nossa missão já era clara: transformar a ida ao dentista em uma experiência acolhedora, sem dor e focada na saúde integral do paciente.</p>
        </div>
        <div class="timeline-marker">
          <div class="marker-dot"></div>
        </div>
      </div>
      
      <!-- Timeline Item 2 - Right -->
      <div class="timeline-item right">
        <div class="timeline-marker">
          <div class="marker-dot"></div>
        </div>
        <div class="timeline-content">
          <div class="timeline-year">2014</div>
          <h4 class="timeline-title">A Primeira Expansão</h4>
          <p class="timeline-description">Com o aumento da confiança dos nossos pacientes, dobramos nossa estrutura física. Inauguramos novas salas de atendimento e trouxemos o primeiro equipamento de raio-x panorâmico 100% digital do bairro, agilizando os diagnósticos.</p>
        </div>
      </div>
      
      <!-- Timeline Item 3 - Left -->
      <div class="timeline-item left">
        <div class="timeline-content">
          <div class="timeline-year">2018</div>
          <h4 class="timeline-title">Formação da Equipe Multidisciplinar</h4>
          <p class="timeline-description">O nosso corpo clínico cresceu. Integrar especialistas de diversas áreas permitiu que a clínica passasse a oferecer tratamentos completos em um só lugar, garantindo mais conforto e praticidade.</p>
        </div>
        <div class="timeline-marker">
          <div class="marker-dot"></div>
        </div>
      </div>
      
      <!-- Timeline Item 4 - Right -->
      <div class="timeline-item right">
        <div class="timeline-marker">
          <div class="marker-dot"></div>
        </div>
        <div class="timeline-content">
          <div class="timeline-year">2021</div>
          <h4 class="timeline-title">A Revolução da Odontologia Digital</h4>
          <p class="timeline-description">Demos um salto tecnológico com a implementação do fluxo digital. Adquirimos scanners intraorais de última geração e impressoras 3D, eliminando de vez aquelas antigas e desconfortáveis massinhas de moldagem.</p>
        </div>
      </div>
      
      <!-- Timeline Item 5 - Left -->
      <div class="timeline-item left">
        <div class="timeline-content">
          <div class="timeline-year">2025</div>
          <h4 class="timeline-title">Inauguração da Nova Sede</h4>
          <p class="timeline-description">Um marco na nossa história! Mudamos para o moderno Edifício Business Center, triplicando nossa capacidade. O novo espaço foi arquitetado com conceitos de neuroarquitetura para reduzir a ansiedade e proporcionar um ambiente de relaxamento total.</p>
        </div>
        <div class="timeline-marker">
          <div class="marker-dot"></div>
        </div>
      </div>
      
      <!-- Timeline Item 6 - Right -->
      <div class="timeline-item right">
        <div class="timeline-marker">
          <div class="marker-dot"></div>
        </div>
        <div class="timeline-content">
          <div class="timeline-year">2026</div>
          <h4 class="timeline-title">15 Anos Transformando Sorrisos</h4>
          <p class="timeline-description">Celebramos uma década e meia de história com mais de 10 mil pacientes atendidos. Olhamos para o futuro mantendo firme o nosso compromisso inicial: unir o que há de mais avançado na ciência ao cuidado genuinamente humano.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Gallery Section -->
<section class="fotos py-5 bg-white">
  <div class="container">
    <div class="section-header text-center mb-5">
      <span class="section-subtitle">NOSSO ESPAÇO</span>
      <h2 class="section-title fw-bold mb-5">Conheça nossa clínica</h2>
      <p class="text-muted mx-auto" style="max-width: 600px;">Um ambiente cuidadosamente projetado para seu conforto, segurança e bem-estar durante todo o tratamento.</p>
    </div>
    
    <!-- Horizontal Scroll Gallery for ALL devices -->
    <div class="gallery-scroll-container">
      <div class="gallery-scroll-track">
        <div class="gallery-scroll-item">
          <div class="gallery-img-container">
            <img src="public/img/sala_espera.jpg" alt="Área de espera confortável" class="gallery-img">
            <div class="gallery-overlay">
              <i class="bi bi-zoom-in overlay-icon"></i>
            </div>
          </div>
        </div>
        <div class="gallery-scroll-item">
          <div class="gallery-img-container">
            <img src="public/img/sala.jpg" alt="Sala de atendimento odontológico" class="gallery-img">
            <div class="gallery-overlay">
              <i class="bi bi-zoom-in overlay-icon"></i>
            </div>
          </div>
        </div>    
        <div class="gallery-scroll-item">
          <div class="gallery-img-container">
            <img src="public/img/medico_sala.jpg" alt="Dentista e paciente em uma sala de atendimento odontológico" class="gallery-img">
            <div class="gallery-overlay">
              <i class="bi bi-zoom-in overlay-icon"></i>
            </div>
          </div>
        </div>            
        <div class="gallery-scroll-item">
          <div class="gallery-img-container">
            <img src="public/img/medica_sala.jpg" alt="Dentista e paciente em uma sala de atendimento odontológico" class="gallery-img">
            <div class="gallery-overlay">
              <i class="bi bi-zoom-in overlay-icon"></i>
            </div>
          </div>
        </div>
        <div class="gallery-scroll-item">
          <div class="gallery-img-container">
            <img src="public/img/medico_mostra.jpg" alt="Dentista e paciente em uma sala de atendimento odontológico" class="gallery-img">
            <div class="gallery-overlay">
              <i class="bi bi-zoom-in overlay-icon"></i>
            </div>
          </div>
        </div>
        <div class="gallery-scroll-item">
          <div class="gallery-img-container">
            <img src="public/img/medico_analiza.jpg" alt="Dentista analizando um raio-X" class="gallery-img">
            <div class="gallery-overlay">
              <i class="bi bi-zoom-in overlay-icon"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
  // Simple animation on scroll
  document.addEventListener('DOMContentLoaded', function() {
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('animate-fade-in');
        }
      });
    }, observerOptions);
    
    // Observe elements that should animate on scroll
    const elementsToAnimate = document.querySelectorAll('.value-card, .timeline-item, .gallery-item, .team-member-card');
    elementsToAnimate.forEach(el => {
      observer.observe(el);
    });
    
    // Gallery lightbox functionality
    const galleryItems = document.querySelectorAll('.gallery-item');
    galleryItems.forEach(item => {
      item.addEventListener('click', function() {
        const imgSrc = this.querySelector('img').src;
        // In a real implementation, you would open a lightbox/modal here
        console.log('Opening image:', imgSrc);
      });
    });
  });
</script>

<?php
$page_content = ob_get_clean();
$page_title = "Início | OdontoCare";

// Inclui o layout
include "layout.php";