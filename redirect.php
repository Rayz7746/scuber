<?php
// Initialize error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the requested page
$page = isset($_GET['page']) ? $_GET['page'] : 'index';

// Define a mapping of allowed pages to their file paths
$allowed_pages = [
    'index' => 'public/index.html',
    'driver-login' => 'public/driver-login.html',
    'driver-signup' => 'public/driver-signup.html',
    'passenger-login' => 'public/passenger-login.html',
    'passenger-signup' => 'public/passenger-signup.html',
    'driver-home' => 'public/driver-home.html',
    'passenger-home' => 'public/passenger-home.html',
    'help' => 'public/help.html'
];

// Check if the requested page exists in our mapping
if (isset($allowed_pages[$page]) && file_exists($allowed_pages[$page])) {
    include($allowed_pages[$page]);
} else {
    // Page not found, redirect to the homepage
    header('Location: /');
    exit;
}
?>