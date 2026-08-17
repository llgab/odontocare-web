<?php
require_once __DIR__ . "/../core/conexao.php";

// Enter this link http://localhost/OdontoCare/app/views/create_admin.php to create the passoword: odontonova!@3
// Abra esse link http://localhost/OdontoCare/app/views/create_admin.php para criar a senha: odontonova!@3


// Hash the password
$password = "odontocare!@3";
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

try {
    $pdo = (new Conexao())->getConexao();
    
    // Check if admin already exists
    $stmt = $pdo->query("SELECT COUNT(*) FROM administrador");
    if ($stmt->fetchColumn() == 0) {
        // Insert the admin
        $stmt = $pdo->prepare("INSERT INTO administrador (password) VALUES (?)");
        $stmt->execute([$hashed_password]);
        echo "Admin password created successfully!<br>";
        echo "Password: " . $password . "<br>";
        echo "Now delete this file for security!";
    } else {
        echo "Admin already exists in database.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>