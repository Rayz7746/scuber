<?php
// Set headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include necessary files
require_once '../config/database.php';
require_once '../models/Driver.php';
require_once '../includes/auth.php';

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Method not allowed"]);
    exit();
}

// Get posted data
$data = json_decode(file_get_contents("php://input"), true);

// Check if username and password are provided
if (!isset($data['username']) || !isset($data['password'])) {
    http_response_code(400); // Bad Request
    echo json_encode(["error" => "Username and password are required"]);
    exit();
}

try {
    // Create driver instance
    $driver = new Driver();
    
    // Attempt to login
    $loggedInDriver = $driver->login($data['username'], $data['password']);
    
    if ($loggedInDriver) {
        // Generate JWT token
        $token = generateToken($loggedInDriver['id'], 'driver');
        
        // Return token
        http_response_code(200);
        echo json_encode(["token" => $token]);
    } else {
        // Invalid credentials
        http_response_code(401);
        echo json_encode(["error" => "Invalid credentials"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal server error: " . $e->getMessage()]);
}