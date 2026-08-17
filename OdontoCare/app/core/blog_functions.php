<?php
require_once "conexao.php";

// Detect BASE_URL dynamically
if (!defined('BASE_URL')) {
    $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    if ($baseUrl === '' || $baseUrl === '.') $baseUrl = '';
    $baseUrl .= '/';
    define('BASE_URL', $baseUrl);
}

// Slugify function
function slugify($text) {
    $text = mb_convert_encoding((string)$text, 'UTF-8', mb_list_encodings());
    $unwanted_array = [
        'À'=>'A','Á'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A','Å'=>'A','Æ'=>'AE',
        'Ç'=>'C','È'=>'E','É'=>'E','Ê'=>'E','Ë'=>'E','Ì'=>'I','Í'=>'I',
        'Î'=>'I','Ï'=>'I','Ñ'=>'N','Ò'=>'O','Ó'=>'O','Ô'=>'O','Õ'=>'O',
        'Ö'=>'O','Ø'=>'O','Ù'=>'U','Ú'=>'U','Û'=>'U','Ü'=>'U','Ý'=>'Y',
        'ß'=>'ss','à'=>'a','á'=>'a','â'=>'a','ã'=>'a','ä'=>'a','å'=>'a',
        'æ'=>'ae','ç'=>'c','è'=>'e','é'=>'e','ê'=>'e','ë'=>'e','ì'=>'i',
        'í'=>'i','î'=>'i','ï'=>'i','ð'=>'o','ñ'=>'n','ò'=>'o','ó'=>'o',
        'ô'=>'o','õ'=>'o','ö'=>'o','ø'=>'o','ù'=>'u','ú'=>'u','û'=>'u',
        'ü'=>'u','ý'=>'y','ÿ'=>'y'
    ];
    $text = strtr($text, $unwanted_array);
    $text = preg_replace('~[^\\pL\\d]+~u', '-', $text);
    $text = trim($text, '-');
    $text = strtolower($text);
    $text = preg_replace('~[^-a-z0-9]+~', '', $text);
    return $text;
}

// Database functions
function getAllPosts() {
    $pdo = (new Conexao())->getConexao();
    $stmt = $pdo->query("SELECT * FROM publicacoes ORDER BY id DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPostById($id) {
    $pdo = (new Conexao())->getConexao();
    $stmt = $pdo->prepare("SELECT * FROM publicacoes WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function toggleFeatured($post_id) {
    $pdo = (new Conexao())->getConexao();
    $stmt = $pdo->prepare("SELECT destaque FROM publicacoes WHERE id = ?");
    $stmt->execute([$post_id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($post) {
        $new_status = $post['destaque'] ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE publicacoes SET destaque = ? WHERE id = ?");
        return $stmt->execute([$new_status, $post_id]);
    }
    return false;
}

// UPDATED: Now handles both images and videos
function updatePost($post_id, $title, $author, $reading_time, $content, $destaque, $media_name = null, $media_type = null) {
    $pdo = (new Conexao())->getConexao();
    if ($media_name) {
        $sql = "UPDATE publicacoes SET titulo = ?, autor = ?, tempo_leitura = ?, conteudo = ?, destaque = ?, media = ?, media_type = ? WHERE id = ?";
        $params = [$title, $author, $reading_time, $content, $destaque, $media_name, $media_type, $post_id];
    } else {
        $sql = "UPDATE publicacoes SET titulo = ?, autor = ?, tempo_leitura = ?, conteudo = ?, destaque = ? WHERE id = ?";
        $params = [$title, $author, $reading_time, $content, $destaque, $post_id];
    }
    $stmt = $pdo->prepare($sql);
    return $stmt->execute($params);
}

// NEW: Alias function for backward compatibility
function updatePostWithMedia($post_id, $title, $author, $reading_time, $content, $destaque, $media_name = null, $media_type = null) {
    return updatePost($post_id, $title, $author, $reading_time, $content, $destaque, $media_name, $media_type);
}

function getFeaturedPost() {
    $pdo = (new Conexao())->getConexao();
    $stmt = $pdo->query("SELECT * FROM publicacoes WHERE destaque = TRUE ORDER BY data_criacao DESC LIMIT 1");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getRegularPosts() {
    $pdo = (new Conexao())->getConexao();
    $stmt = $pdo->query("SELECT * FROM publicacoes WHERE destaque = FALSE OR destaque IS NULL ORDER BY data_criacao DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getLatestPosts($limit = 3) {
    $pdo = (new Conexao())->getConexao();
    $stmt = $pdo->prepare("SELECT * FROM publicacoes ORDER BY data_criacao DESC LIMIT ?");
    $stmt->bindValue(1, $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// UPDATED: Now validates both images and videos
function validateMedia($file) {
    $allowedImageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    $allowedVideoTypes = ['video/mp4', 'video/quicktime', 'video/x-msvideo', 'video/webm'];
    $maxImageSize = 5 * 1024 * 1024; // 5MB
    $maxVideoSize = 20 * 1024 * 1024; // 20MB
    
    if ($file['error'] !== UPLOAD_ERR_OK) return "Erro no upload do arquivo.";
    
    if (in_array($file['type'], $allowedImageTypes)) {
        if ($file['size'] > $maxImageSize) {
            return 'A imagem deve ter no máximo 5MB.';
        }
        if (!getimagesize($file['tmp_name'])) {
            return 'O arquivo não é uma imagem válida.';
        }
    } elseif (in_array($file['type'], $allowedVideoTypes)) {
        if ($file['size'] > $maxVideoSize) {
            return 'O vídeo deve ter no máximo 20MB.';
        }
    } else {
        return 'Tipo de arquivo não suportado. Use imagens (JPG, PNG, GIF, WEBP) ou vídeos (MP4, MOV, AVI, WEBM).';
    }
    
    return true;
}

// NEW: Backward compatibility function
function validateImage($file) {
    return validateMedia($file);
}

// UPDATED: Delete post function to handle media field
function deletePost($id) {
    $pdo = (new Conexao())->getConexao();
    $post = getPostById($id);
    if ($post && $post['media'] && file_exists("uploads/" . $post['media'])) {
        unlink("uploads/" . $post['media']);
    }
    $stmt = $pdo->prepare("DELETE FROM publicacoes WHERE id = ?");
    return $stmt->execute([$id]);
}
?>