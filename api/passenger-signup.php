<?php
// Set headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Include necessary files
require_once '../config/database.php';
require_once '../models/Passenger.php';

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(["error" => "Method not allowed"]);
    exit();
}

// Get posted data
$data = json_decode(file_get_contents("php://input"), true);

// Validate required fields
$requiredFields = [
    'name', 'username', 'password', 'major', 'homeLocation', 
    'homeCoordinates', 'schedule', 'musicTastes', 'gender', 
    'genderPreference', 'phoneNumber'
];

foreach ($requiredFields as $field) {
    if (!isset($data[$field])) {
        http_response_code(400);
        echo json_encode(["error" => "$field is required"]);
        exit();
    }
}

// Validate nested fields
if (!isset($data['homeCoordinates']['latitude']) || !isset($data['homeCoordinates']['longitude'])) {
    http_response_code(400);
    echo json_encode(["error" => "Home coordinates are required"]);
    exit();
}

$scheduleFields = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
foreach ($scheduleFields as $field) {
    if (!isset($data['schedule'][$field])) {
        http_response_code(400);
        echo json_encode(["error" => "Schedule for $field is required"]);
        exit();
    }
}

try {
    // Create database instance and initialize tables
    $database = Database::getInstance();
    $database->initializeTables();
    
    // Create passenger instance
    $passenger = new Passenger();
    
    // Create the passenger
    if ($passenger->create($data)) {
        http_response_code(200);
        echo json_encode(["message" => "Passenger signed up successfully"]);
    } else {
        http_response_code(500);
        echo json_encode(["error" => "An error occurred while signing up"]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => "Internal server error: " . $e->getMessage()]);
}