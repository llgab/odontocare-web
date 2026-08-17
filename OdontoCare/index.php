<?php
// ROOT/index.php — handles clean URLs and slugged posts

error_reporting(E_ALL);
ini_set('display_errors', 1);

// All valid pages
$allPages = ['home', 'servicos', 'blog', 'post', 'sobre', 'contato', 'login', 'admin_blog'];

// Get requested URL
$url = $_GET['url'] ?? 'home';
$url = trim($url, '/');

// Detect if it's a post with slug (e.g., post/apneia-do-sono-4)
if (preg_match('#^post/(.+)-(\d+)$#u', $url, $matches)) { // added "u" for UTF-8 support
    $_GET['slug'] = $matches[1]; // capture the slug
    $_GET['id'] = $matches[2];   // capture post ID
    $page = 'post';
} else {
    // Remove .php extension if present
    $page = str_replace('.php', '', $url);
}

// Define paths
$viewPath = __DIR__ . '/app/views/' . $page . '.php';
$errorPath = __DIR__ . '/app/views/errors/404.php';

// Load page or 404
if (in_array($page, $allPages) && file_exists($viewPath)) {
    require_once $viewPath;
} else {
    http_response_code(404);
    require_once $errorPath;
}
