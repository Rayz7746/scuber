<?php
require_once __DIR__ . '/../config/database.php';

class Driver {
    private $conn;
    private $table = 'drivers';
    
    // Driver properties
    public $id;
    public $name;
    public $username;
    public $password;
    public $major;
    public $homeLocation;
    public $homeLatitude;
    public $homeLongitude;
    public $scheduleMonday;
    public $scheduleTuesday;
    public $scheduleWednesday;
    public $scheduleThursday;
    public $scheduleFriday;
    public $musicTastes;
    public $gender;
    public $genderPreference;
    public $phoneNumber;
    
    // Constructor with DB connection
    public function __construct() {
        $database = Database::getInstance();
        $this->conn = $database->getConnection();
    }
    
    // Create new driver
    public function create($data) {
        // Prepare query
        $query = "INSERT INTO " . $this->table . "
            (name, username, password, major, homeLocation, homeLatitude, homeLongitude, 
            scheduleMonday, scheduleTuesday, scheduleWednesday, scheduleThursday, scheduleFriday, 
            musicTastes, gender, genderPreference, phoneNumber) 
            VALUES 
            (:name, :username, :password, :major, :homeLocation, :homeLatitude, :homeLongitude, 
            :scheduleMonday, :scheduleTuesday, :scheduleWednesday, :scheduleThursday, :scheduleFriday, 
            :musicTastes, :gender, :genderPreference, :phoneNumber)";
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and bind data
        $name = htmlspecialchars(strip_tags($data['name']));
        $username = htmlspecialchars(strip_tags($data['username']));
        $password = htmlspecialchars(strip_tags($data['password']));
        $major = htmlspecialchars(strip_tags($data['major']));
        $homeLocation = htmlspecialchars(strip_tags($data['homeLocation']));
        $homeLatitude = floatval($data['homeCoordinates']['latitude']);
        $homeLongitude = floatval($data['homeCoordinates']['longitude']);
        $scheduleMonday = htmlspecialchars(strip_tags($data['schedule']['monday']));
        $scheduleTuesday = htmlspecialchars(strip_tags($data['schedule']['tuesday']));
        $scheduleWednesday = htmlspecialchars(strip_tags($data['schedule']['wednesday']));
        $scheduleThursday = htmlspecialchars(strip_tags($data['schedule']['thursday']));
        $scheduleFriday = htmlspecialchars(strip_tags($data['schedule']['friday']));
        $musicTastes = json_encode($data['musicTastes']);
        $gender = htmlspecialchars(strip_tags($data['gender']));
        $genderPreference = htmlspecialchars(strip_tags($data['genderPreference']));
        $phoneNumber = htmlspecialchars(strip_tags($data['phoneNumber']));
        
        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':major', $major);
        $stmt->bindParam(':homeLocation', $homeLocation);
        $stmt->bindParam(':homeLatitude', $homeLatitude);
        $stmt->bindParam(':homeLongitude', $homeLongitude);
        $stmt->bindParam(':scheduleMonday', $scheduleMonday);
        $stmt->bindParam(':scheduleTuesday', $scheduleTuesday);
        $stmt->bindParam(':scheduleWednesday', $scheduleWednesday);
        $stmt->bindParam(':scheduleThursday', $scheduleThursday);
        $stmt->bindParam(':scheduleFriday', $scheduleFriday);
        $stmt->bindParam(':musicTastes', $musicTastes);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':genderPreference', $genderPreference);
        $stmt->bindParam(':phoneNumber', $phoneNumber);
        
        // Execute query
        if($stmt->execute()) {
            return true;
        }
        
        return false;
    }
    
    // Login driver
    public function login($username, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE username = :username AND password = :password";
        $stmt = $this->conn->prepare($query);
        
        // Sanitize and bind data
        $username = htmlspecialchars(strip_tags($username));
        $password = htmlspecialchars(strip_tags($password));
        
        // Bind parameters
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        
        // Execute query
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Get driver by ID
    public function read_single($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        // Bind ID
        $stmt->bindParam(':id', $id);
        
        // Execute query
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    // Get all drivers
    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}