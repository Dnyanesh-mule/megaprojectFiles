<?php
$host = 'localhost';
$dbname = 'siregaon_bandh';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    
    // Verify table structure exists with all columns
    $pdo->exec("CREATE TABLE IF NOT EXISTS newspaper (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        image_data LONGBLOB NOT NULL,
        mime_type VARCHAR(50) NOT NULL,
        size INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>