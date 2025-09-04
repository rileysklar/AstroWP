<?php
/**
 * WordPress configuration for Cloud Run deployment
 */

// Database configuration
define('DB_NAME', $_ENV['DB_NAME'] ?? 'wordpress');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? '');
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

// Database table prefix
$table_prefix = 'wp_';

// Authentication keys and salts
define('AUTH_KEY',         $_ENV['AUTH_KEY'] ?? 'put your unique phrase here');
define('SECURE_AUTH_KEY',  $_ENV['SECURE_AUTH_KEY'] ?? 'put your unique phrase here');
define('LOGGED_IN_KEY',    $_ENV['LOGGED_IN_KEY'] ?? 'put your unique phrase here');
define('NONCE_KEY',        $_ENV['NONCE_KEY'] ?? 'put your unique phrase here');
define('AUTH_SALT',        $_ENV['AUTH_SALT'] ?? 'put your unique phrase here');
define('SECURE_AUTH_SALT', $_ENV['SECURE_AUTH_SALT'] ?? 'put your unique phrase here');
define('LOGGED_IN_SALT',   $_ENV['LOGGED_IN_SALT'] ?? 'put your unique phrase here');
define('NONCE_SALT',       $_ENV['NONCE_SALT'] ?? 'put your unique phrase here');

// WordPress settings
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);

// Disable file editing in admin
define('DISALLOW_FILE_EDIT', true);

// Set home and site URL
define('WP_HOME', $_ENV['WP_HOME'] ?? 'https://astrowp-backend-xr7l6t3uja-uc.a.run.app');
define('WP_SITEURL', $_ENV['WP_SITEURL'] ?? 'https://astrowp-backend-xr7l6t3uja-uc.a.run.app');

// Allow WordPress to detect HTTPS
define('FORCE_SSL_ADMIN', true);

// Increase memory limit
define('WP_MEMORY_LIMIT', '256M');

// Disable automatic updates
define('AUTOMATIC_UPDATER_DISABLED', true);

// Disable file modifications
define('DISALLOW_FILE_MODS', true);

// Set upload directory
define('UPLOAD_PATH', '/tmp/uploads');

// Load WordPress
require_once(ABSPATH . 'wp-settings.php');
