<?php
if (!defined('BASE_URL')) {
    // Get the current script directory (e.g., /OdontoCare/app/core)
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
    $scriptDir = preg_replace('#/+#', '/', $scriptDir);

    // If script is in /app/core, move up two levels to reach /OdontoCare/
    if (preg_match('#/app/core$#', $scriptDir)) {
        $scriptDir = dirname(dirname($scriptDir)); 
    }

    // Ensure trailing slash
    $baseUrl = rtrim($scriptDir, '/') . '/';
    define('BASE_URL', $baseUrl);
}

function requireAdminLogin() {
    session_start();

    // Check if logged in
    if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
        header('Location: ' . BASE_URL . 'login.php');
        exit;
    }

    // Optional: 30 min session timeout
    if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 1800)) {
        session_destroy();
        header('Location: ' . BASE_URL . 'login.php?expired=1');
        exit;
    }

    // Refresh login time
    $_SESSION['login_time'] = time();
}

function adminLogout() {
    session_start();
    session_destroy();
    header('Location: ' . BASE_URL . 'login.php');
    exit;
}
