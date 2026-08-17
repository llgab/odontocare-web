<?php
ob_start();
?>

<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center">
        <h1 class="fw-bold display-6 mb-3 section-title">Nossos Serviços</h1>
        <p class="lead text-muted mx-auto mb-5" style="max-width: 600px;">Oferecemos tratamentos odontológicos completos com tecnologia de ponta e profissionais especializados</p>
      </div>
    </div>

<?php
    $servicos = [
      [
        "titulo" => "Implantes Dentários",
        "descricao" => "Devolva a função e a beleza do seu sorriso. Utilizamos pinos de titânio de alta tecnologia para substituir dentes perdidos, garantindo resultados naturais, seguros e duradouros que parecem e funcionam como dentes reais."
      ],
      [
        "titulo" => "Ortodontia e Alinhadores Invisíveis", 
        "descricao" => "Corrija o alinhamento dos seus dentes com conforto e estética. Oferecemos desde os tradicionais aparelhos estéticos até os modernos alinhadores transparentes (invisíveis), para um tratamento rápido e super discreto."
      ],
      [
        "titulo" => "Lentes de Contato Dental",
        "descricao" => "Transforme seu sorriso em poucas sessões. As lentes são lâminas ultrafinas de porcelana aplicadas sobre os dentes para corrigir formato, tamanho, cor e pequenos desgastes, criando uma estética impecável e harmoniosa."
      ],
      [
        "titulo" => "Clareamento Dental",
        "descricao" => "Recupere a luminosidade dos seus dentes com total segurança. Nossos tratamentos de clareamento (a laser no consultório ou caseiro com acompanhamento) removem manchas e amarelados, proporcionando um sorriso branco e radiante sem causar sensibilidade."
      ],
      [
        "titulo" => "Clínica Geral e Prevenção",
        "descricao" => "A base para uma boca saudável. Realizamos check-ups regulares, profilaxia (limpeza profissional) e remoção de tártaro para prevenir cáries e inflamações, garantindo que sua saúde bucal esteja sempre em dia."
      ],
      [
        "titulo" => "Odontopediatria (Odontologia Infantil)",
        "descricao" => "Cuidado especial para os pequenos. Atendimento lúdico, paciente e sem traumas, focado na prevenção e na educação em saúde bucal, para que as crianças cresçam com sorrisos fortes e sem medo do dentista."
      ],
      [
        "titulo" => "Endodontia (Tratamento de Canal)",
        "descricao" => "Salve o seu dente natural de forma indolor. Com o uso de anestesias modernas e equipamentos automatizados, tratamos infecções na raiz do dente de maneira rápida, confortável e altamente precisa."
      ],
      [
        "titulo" => "Periodontia (Tratamento de Gengiva)",
        "descricao" => "Cuidado dedicado à fundação do seu sorriso. Tratamos sangramentos, inflamações (gengivite) e infecções ósseas (periodontite) para manter os tecidos de suporte dos seus dentes perfeitamente saudáveis."
      ],
      [
        "titulo" => "Próteses Dentárias e Reabilitação",
        "descricao" => "Soluções sob medida para devolver sua autoestima e mastigação. Oferecemos próteses fixas, móveis e coroas de porcelana feitas com tecnologia digital para garantir o máximo de conforto e adaptação."
      ],
      [
        "titulo" => "Harmonização Orofacial",
        "descricao" => "O complemento perfeito para o seu novo sorriso. Procedimentos seguros e minimamente invasivos (como aplicação de toxina botulínica e preenchimentos) para equilibrar as proporções do rosto, suavizar linhas de expressão e realçar sua beleza natural."
      ]
    ];
    ?>

    <div class="row g-4 services-grid">
      <?php foreach ($servicos as $servico): ?>
        <div class="col-md-6 col-md-6">
          <div class="service-card p-4 rounded-3 h-100">
            <div class="service-header">
              <h4 class="service-title fw-bold"><?= $servico['titulo'] ?></h4>
            </div>
            
            <div class="service-content">
              <p class="service-description"><?= $servico['descricao'] ?></p>
            </div>
            
            <div class="service-toggle d-lg-none">
              <span class="toggle-text">Ler mais</span>
              <i class="toggle-icon">↓</i>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

  </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
  if (window.innerWidth <= 768) {
    document.querySelectorAll('.service-toggle').forEach(toggle => {
      toggle.addEventListener('click', () => {
        const card = toggle.closest('.service-card');
        card.classList.toggle('expanded');
        const text = toggle.querySelector('.toggle-text');
        text.textContent = card.classList.contains('expanded') ? 'Ler menos' : 'Ler mais';
      });
    });
  }
});
</script>

<?php
$page_content = ob_get_clean();
$page_title = "Serviços | OdontoCare";
include "layout.php";

?>