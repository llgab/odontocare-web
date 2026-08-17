<?php
require_once __DIR__ . "/../core/conexao.php";
// Include PHPMailer
require_once __DIR__ . '/../../vendor/autoload.php'; // If using Composer
// OR if manual installation:
// require_once __DIR__ . '/../phpmailer/src/PHPMailer.php';
// require_once __DIR__ . '/../phpmailer/src/SMTP.php';
// require_once __DIR__ . '/../phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mensagem = '';
$tipoMensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefone = $_POST['telefone'] ?? '';
    $mensagem_texto = $_POST['mensagem'] ?? '';
    
    if (empty($nome) || empty($email) || empty($mensagem_texto)) {
        $mensagem = 'Por favor, preencha todos os campos obrigatórios.';
        $tipoMensagem = 'erro';
    } else {
        try {
            $conexao = (new Conexao())->getConexao();
            
            $sql = "INSERT INTO contatos (nome, email, telefone, mensagem, data_contato) 
                    VALUES (:nome, :email, :telefone, :mensagem, NOW())";
            
            $stmt = $conexao->prepare($sql);
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':telefone', $telefone);
            $stmt->bindValue(':mensagem', $mensagem_texto);
            
            if ($stmt->execute()) {
                // Send email notification
                if (enviarEmailContato($nome, $email, $telefone, $mensagem_texto)) {
                    $mensagem = 'Mensagem enviada com sucesso! Entraremos em contato em breve.';
                    $tipoMensagem = 'sucesso';
                } else {
                    $mensagem = 'Mensagem salva, mas houve um problema no envio do email. Entraremos em contato em breve.';
                    $tipoMensagem = 'aviso';
                }
                
                // Limpar os campos do formulário
                $_POST = array();
            } else {
                $mensagem = 'Erro ao enviar mensagem. Tente novamente.';
                $tipoMensagem = 'erro';
            }
        } catch (PDOException $e) {
            $mensagem = 'Erro no sistema: ' . $e->getMessage();
            $tipoMensagem = 'erro';
        }
    }
}

/* Send contact form email using PHPMailer */
function enviarEmailContato($nome, $email, $telefone, $mensagem) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = '';  // Your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = '';  // Your email
        $mail->Password   = '';           // Your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Or ENCRYPTION_SMTPS
        $mail->Port       = 465;     
        $mail->CharSet    = 'UTF-8';

        // Recipients
        $mail->setFrom('', 'Site OdontoCare'); // Your email
        $mail->addAddress('', 'OdontoCare'); // Main recipient
        $mail->addReplyTo($email, $nome); // So you can reply directly to the customer

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Novo Contato do Site OdontoCare - ' . $nome;
        
        $mail->Body = "
            <h2>Novo Contato do Site</h2>
            <p><strong>Nome:</strong> {$nome}</p>
            <p><strong>Email:</strong> {$email}</p>
            <p><strong>Telefone:</strong> " . ($telefone ?: 'Não informado') . "</p>
            <p><strong>Mensagem:</strong></p>
            <div style='background: #f8f9fa; padding: 15px; border-radius: 5px;'>
                " . nl2br(htmlspecialchars($mensagem)) . "
            </div>
            <br>
            <p><small>Enviado em: " . date('d/m/Y H:i:s') . "</small></p>
        ";
        
        // Plain text version
        $mail->AltBody = "
            NOVO CONTATO DO SITE
            Nome: {$nome}
            Email: {$email}
            Telefone: " . ($telefone ?: 'Não informado') . "
            Mensagem: {$mensagem}
            Enviado em: " . date('d/m/Y H:i:s');

        $mail->send();
        return true;
        
    } catch (Exception $e) {
        // Log the error but don't show to user
        error_log("Erro no envio de email: " . $mail->ErrorInfo);
        return false;
    }
}

ob_start();
?>

<section class="contact-page">
  <div class="contact-intro py-5">
    <div class="container">
      <!-- Cabeçalho -->
      <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center">
          <h1 class="fw-bold display-6 mb-3 section-title">Entre em Contato</h1>
          <p class="lead text-muted">Estamos aqui para cuidar do seu sorriso. Entre em contato conosco.</p>
        </div>
      </div>

      <?php if ($mensagem): ?>
        <div class="row justify-content-center mb-4">
          <div class="col-lg-8">
            <div class="alert alert-<?= 
                $tipoMensagem === 'sucesso' ? 'success' : 
                ($tipoMensagem === 'aviso' ? 'warning' : 'danger') 
            ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($mensagem) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
          </div>
        </div>
      <?php endif; ?>

      <!-- Seção de Contato -->
      <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
          <div class="contact-section">
            <div class="row g-4">
              <div class="col-md-4">
                <div class="contact-item text-center">
                  <i class="fas fa-phone contact-icon mb-3"></i>
                  <h5 class="fw-bold mb-2 contact-title">Telefone</h5>
                  <p class="contact-text mb-0">(99) 9999-9999</p>
                  <p class="contact-text mb-0">(99) 9999-9999</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="contact-item text-center">
                  <i class="fas fa-envelope contact-icon mb-3"></i>
                  <h5 class="fw-bold mb-2 contact-title">E-mail</h5>
                  <p class="contact-text mb-0">OdontoCareFake@gmail.com</p>
                </div>
              </div>
              <div class="col-md-4">
                <div class="contact-item text-center">
                  <i class="fas fa-share-alt contact-icon mb-3"></i>
                  <h5 class="fw-bold mb-2 contact-title">Redes Sociais</h5>
                  <div class="social-links">
                    <a href="https://www.facebook.com/odonto_care_fake/?locale=pt_BR" class="social-link">
                      <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/odonto_care_fake/?hl=en" class="social-link">
                      <i class="fab fa-instagram"></i>
                    </a>                    
                    <a href="https://wa.me/9999999999999" class="social-link">
                      <i class="fab fa-whatsapp"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Light gray form section -->
  <div class="contact-form-bg py-5">
    <div class="container">
      <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
          <div class="form-section">
            <h3 class="fw-bold mb-4 text-center">Envie uma Mensagem</h3>
            <form method="POST" action="" class="contact-form">
              <div class="row g-3">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="nome" class="form-label fw-semibold">Nome Completo *</label>
                    <input type="text" class="form-control" id="nome" name="nome" 
                           value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>" required 
                           placeholder="Seu nome completo">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="email" class="form-label fw-semibold">E-mail *</label>
                    <input type="email" class="form-control" id="email" name="email" 
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required 
                           placeholder="seu@email.com">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="telefone" class="form-label fw-semibold">Telefone</label>
                    <input type="tel" class="form-control" id="telefone" name="telefone" 
                           value="<?= htmlspecialchars($_POST['telefone'] ?? '') ?>" 
                           placeholder="(11) 99999-9999">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                    <label for="mensagem" class="form-label fw-semibold">Mensagem *</label>
                    <textarea class="form-control" id="mensagem" name="mensagem" 
                              rows="5" required 
                              placeholder="Descreva sua mensagem..."><?= htmlspecialchars($_POST['mensagem'] ?? '') ?></textarea>
                  </div>
                </div>
                <div class="col-12 text-center">
                  <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane me-2"></i>Enviar Mensagem
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- White again for map section -->
  <div class="contact-map-bg py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="location-map-section">
            <h3 class="fw-bold mb-4 text-center">Localização</h3>
            <div class="row g-4">
              <div class="col-lg-4">
                <div class="location-info">
                  <div class="location-item mb-4">
                    <h5 class="fw-bold mb-2 contact-title">Endereço</h5>
                    <p class="contact-text mb-0">
                      Av Pereira Teixeira, 482<br>
                      Sala 103<br>
                      Centro<br>
                      Barbacena - MG<br>
                      36.200-034
                    </p>
                  </div>
                  <div class="location-item">
                    <h5 class="fw-bold mb-2 contact-title">Horário de Funcionamento</h5>
                    <div class="contact-text">
                      <p class="mb-1"><strong>Segunda a Sexta:</strong><br> 8h às 12h e 13:30h às 18:30h</p>
                      <p class="mb-1"><strong>Sábado:</strong> 8h às 12h</p>
                      <p class="mb-0"><strong>Domingo:</strong> Fechado</p>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="location-divider"></div>
                <div class="map-container">
                  <div class="ratio ratio-16x9">
                    <iframe
                      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3719.2111914180546!2d-43.7805849249629!3d-21.223472380475012!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xa221b0ecc8367d%3A0x497b08a6ca23e123!2sPrefeitura%20Municipal%20de%20Barbacena!5e0!3m2!1sen!2sbr!4v1786812122600!5m2!1sen!2sbr"
                      style="border:0;" 
                      allowfullscreen="" 
                      loading="lazy" 
                      referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                  </div>
                </div>
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
$page_title = "Contato | OdontoCare";
include "layout.php";
?>