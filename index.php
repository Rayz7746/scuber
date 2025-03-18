<?php
// Initialize error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database configuration
require_once 'config/database.php';

try {
    // Initialize database tables
    $database = Database::getInstance();
    $database->initializeTables();
    
    // Include the main index HTML file
    include_once 'public/index.html';
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}