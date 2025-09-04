<?php
// Emergency WordPress redirect disable
// This script will completely disable WordPress redirects

// Database connection
$host = $_ENV['DB_HOST'] ?? '34.10.12.56';
$dbname = $_ENV['DB_NAME'] ?? 'wordpress';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? 'YourSecurePassword123!';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Disable ALL redirects
    $redirects_to_disable = [
        'redirect_guess_404_to_fixed' => '0',
        'permalink_structure' => '',
        'rewrite_rules' => '',
        'siteurl' => 'https://astrowp-backend-xr7l6t3uja-uc.a.run.app',
        'home' => 'https://astrowp-backend-xr7l6t3uja-uc.a.run.app'
    ];
    
    foreach ($redirects_to_disable as $option_name => $option_value) {
        $stmt = $pdo->prepare("UPDATE wp_options SET option_value = ? WHERE option_name = ?");
        $stmt->execute([$option_value, $option_name]);
    }
    
    // Delete any cached redirects
    $stmt = $pdo->prepare("DELETE FROM wp_options WHERE option_name LIKE '%redirect%' AND option_name != 'redirect_guess_404_to_fixed'");
    $stmt->execute();
    
    echo "ALL WordPress redirects disabled!\n";
    echo "Try accessing: https://astrowp-backend-xr7l6t3uja-uc.a.run.app/wp-login.php\n";
    echo "If that doesn't work, try: https://astrowp-backend-xr7l6t3uja-uc.a.run.app/\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
