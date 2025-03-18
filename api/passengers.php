<?php
// Set headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Include necessary files
require_once '../config/database.php';
require_once '../models/Driver.php';
require_once '../models/Passenger.php';
require_once '../includes/auth.php';
require_once '../includes/helpers.php';

// Get the token from headers
$token = getAuthorizationToken();
$payload = verifyToken($token);

// Check if token is valid
if (!$payload) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

// Check if user is a driver (only drivers can access passenger list)
if ($payload['userType'] !== 'driver') {
    http_response_code(403);
    echo json_encode(["error" => "Forbidden"]);
    exit();
}

// Process POST request for matching
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get posted data
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Check if priorities are set
    if (!isset($data['priorities']) || !is_array($data['priorities'])) {
        http_response_code(400);
        echo json_encode(["error" => "Priorities are required"]);
        exit();
    }
    
    try {
        // Get driver data
        $driver = new Driver();
        $driverData = $driver->read_single($payload['id']);
        
        if (!$driverData) {
            http_response_code(404);
            echo json_encode(["error" => "Driver not found"]);
            exit();
        }
        
        // Get all passengers
        $passenger = new Passenger();
        $passengers = $passenger->read();
        
        $priorities = $data['priorities'];
        $maxScore = count($priorities) + 1; // Maximum possible score
        $sortedPassengers = [];
        
        foreach ($passengers as $passengerData) {
            $score = 0;
            $musicScore = 0;
            
            // Calculate distance
            $distance = calculateDistance(
                $driverData['homeLatitude'], 
                $driverData['homeLongitude'], 
                $passengerData['homeLatitude'], 
                $passengerData['homeLongitude']
            );
            
            // Calculate scores based on priorities
            foreach ($priorities as $priority) {
                if ($priority === 'musicTastes') {
                    $driverMusicTastes = json_decode($driverData['musicTastes'], true);
                    $passengerMusicTastes = json_decode($passengerData['musicTastes'], true);
                    $musicScore = calculateMusicMatch($driverMusicTastes, $passengerMusicTastes);
                    $score += $musicScore;
                }
                
                if ($priority === 'gender' && 
                    ($driverData['genderPreference'] === 'All' || $passengerData['gender'] === $driverData['gender'])) {
                    $score += 1;
                }
                
                if ($priority === 'distance') {
                    $score += 1 / ($distance + 1); // Inverse of distance as score
                }
            }
            
            $normalizedScore = normalizeScore($score, $maxScore);
            
            $sortedPassengers[] = [
                'name' => $passengerData['name'],
                'major' => $passengerData['major'],
                'distance' => number_format($distance, 2) . ' km',
                'score' => number_format($normalizedScore, 2),
                'musicScore' => number_format($musicScore, 2),
                'phoneNumber' => $passengerData['phoneNumber']
            ];
        }
        
        // Sort passengers by score (descending)
        usort($sortedPassengers, function($a, $b) {
            return $b['score'] <=> $a['score'];
        });
        
        // Return the sorted list
        echo json_encode($sortedPassengers);
        
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Internal server error: " . $e->getMessage()]);
    }
}