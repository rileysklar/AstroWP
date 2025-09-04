<?php
// Fix WordPress site URL redirect loop
// This script will update the site URL in the database

// Database connection
$host = $_ENV['DB_HOST'] ?? '34.10.12.56';
$dbname = $_ENV['DB_NAME'] ?? 'wordpress';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? 'YourSecurePassword123!';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Update site URL
    $site_url = 'https://astrowp-backend-xr7l6t3uja-uc.a.run.app';
    
    $stmt = $pdo->prepare("UPDATE wp_options SET option_value = ? WHERE option_name = 'home'");
    $stmt->execute([$site_url]);
    
    $stmt = $pdo->prepare("UPDATE wp_options SET option_value = ? WHERE option_name = 'siteurl'");
    $stmt->execute([$site_url]);
    
    echo "Site URL updated successfully to: $site_url\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
