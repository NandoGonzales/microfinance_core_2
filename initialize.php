<?php
$dev_data = array(
    'id' => '-1',
    'firstname' => 'Developer',
    'lastname' => '',
    'username' => 'dev_oretnom',
    'password' => '5da283a2d990e8d8512cf967df5bc0d0',
    'last_login' => '',
    'date_updated' => '',
    'date_added' => ''
);

if (!defined('base_url')) define('base_url', 'http://localhost/coreT2/');
if (!defined('base_app')) define('base_app', str_replace('\\', '/', __DIR__) . '/');

// ===============================
// DATABASE CONFIG (LOCAL vs LIVE)
// ===============================
if (!defined('DB_SERVER')) {

    if (
        $_SERVER['SERVER_NAME'] === 'localhost' ||
        $_SERVER['SERVER_ADDR'] === '127.0.0.1'
    ) {
        // ✅ LOCAL (XAMPP)
        define('DB_SERVER', 'localhost');
        define('DB_USERNAME', 'root');
        define('DB_PASSWORD', '');
        define('DB_NAME', 'core2_db');
    } else {
        // 🚀 LIVE (cPanel)
        define('DB_SERVER', 'localhost');
        define('DB_USERNAME', 'core2_coreTREWQmic2');
        define('DB_PASSWORD', 'OuP@Gshtg#9floiP');
        define('DB_NAME', 'core2_db');
    }
}
