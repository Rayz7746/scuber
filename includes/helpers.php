<?php
// Helper functions for the SCUBER application

// Calculate distance between two coordinates using Haversine formula
function calculateDistance($lat1, $lon1, $lat2, $lon2) {
    $R = 6371; // Radius of the Earth in kilometers
    $dLat = deg2rad($lat2 - $lat1);
    $dLon = deg2rad($lon2 - $lon1);
    $a = sin($dLat / 2) * sin($dLat / 2) +
        cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        sin($dLon / 2) * sin($dLon / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $distance = $R * $c;
    return $distance;
}

// Calculate music taste match score
function calculateMusicMatch($tastes1, $tastes2) {
    if (empty($tastes1) || empty($tastes2)) {
        return 0; // Return 0 if either party has no music tastes defined
    }
    
    // Ensure we're working with arrays
    if (is_string($tastes1)) {
        $tastes1 = json_decode($tastes1, true);
    }
    
    if (is_string($tastes2)) {
        $tastes2 = json_decode($tastes2, true);
    }
    
    // Count matching tastes
    $matches = 0;
    foreach ($tastes1 as $taste) {
        if (in_array($taste, $tastes2)) {
            $matches++;
        }
    }
    
    return count($tastes1) > 0 ? $matches / count($tastes1) : 0; // Proportion of matches
}

// Normalize score to 1-10 range
function normalizeScore($score, $maxScore) {
    return 1 + 9 * ($score / $maxScore); // Normalize to 1-10 range
}

// Get request data (JSON)
function getRequestData() {
    $json = file_get_contents('php://input');
    return json_decode($json, true);
}

// Send JSON response
function sendJsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit();
}

// Handle error response
function sendErrorResponse($message, $statusCode = 500) {
    http_response_code($statusCode);
    echo json_encode(['error' => $message]);
    exit();
}