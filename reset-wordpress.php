<?php
// Complete WordPress reset
// This script will drop all tables and reset WordPress completely

// Database connection
$host = $_ENV['DB_HOST'] ?? '34.10.12.56';
$dbname = $_ENV['DB_NAME'] ?? 'wordpress';
$username = $_ENV['DB_USER'] ?? 'root';
$password = $_ENV['DB_PASSWORD'] ?? 'YourSecurePassword123!';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Drop all WordPress tables
    $tables = ['wp_options', 'wp_posts', 'wp_comments', 'wp_links', 'wp_terms', 'wp_term_taxonomy', 'wp_term_relationships', 'wp_usermeta', 'wp_users'];
    
    foreach ($tables as $table) {
        try {
            $pdo->exec("DROP TABLE IF EXISTS $table");
            echo "Dropped table: $table\n";
        } catch (Exception $e) {
            echo "Could not drop $table: " . $e->getMessage() . "\n";
        }
    }
    
    echo "\nWordPress database completely reset!\n";
    echo "You can now reinstall WordPress at: https://astrowp-backend-xr7l6t3uja-uc.a.run.app/wp-admin/install.php\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
