<?php
// db-test.php in your root folder
require_once 'config/database.php';

try {
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    // Try a simple query
    $stmt = $conn->query("SELECT 1");
    echo "Database connection successful!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}