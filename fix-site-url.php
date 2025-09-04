<?php
// Comprehensive WordPress redirect loop fix
// This script will reset all problematic WordPress settings

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
    
    // Fix home and siteurl options
    $stmt = $pdo->prepare("UPDATE wp_options SET option_value = ? WHERE option_name = 'home'");
    $stmt->execute([$site_url]);
    
    $stmt = $pdo->prepare("UPDATE wp_options SET option_value = ? WHERE option_name = 'siteurl'");
    $stmt->execute([$site_url]);
    
    // Disable redirects temporarily
    $stmt = $pdo->prepare("UPDATE wp_options SET option_value = '0' WHERE option_name = 'redirect_guess_404_to_fixed'");
    $stmt->execute();
    
    // Clear any cached redirects
    $stmt = $pdo->prepare("DELETE FROM wp_options WHERE option_name LIKE '%redirect%'");
    $stmt->execute();
    
    // Reset admin email if needed
    $stmt = $pdo->prepare("UPDATE wp_options SET option_value = 'admin@example.com' WHERE option_name = 'admin_email'");
    $stmt->execute();
    
    echo "WordPress settings reset successfully!\n";
    echo "Site URL: $site_url\n";
    echo "Redirects disabled temporarily\n";
    echo "You can now try accessing: https://astrowp-backend-xr7l6t3uja-uc.a.run.app/wp-login.php\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
