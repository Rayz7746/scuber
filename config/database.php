<?php
// Database connection class
class Database {
    private static $instance = null;
    private $pdo;
    private $host = 'localhost';
    private $db_name = 'scuber';
    private $username = 'root';
    private $password = '';
    private $charset = 'utf8mb4';


    // Private constructor to enforce singleton pattern
    private function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    // Get instance (singleton pattern)
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Get PDO connection
    public function getConnection() {
        $this->pdo->exec("SET NAMES utf8mb4");
        $this->pdo->exec("SET innodb_strict_mode=0");
        return $this->pdo;
    }

    // Initialize database by creating tables if they don't exist
    public function initializeTables() {
        // Create drivers table

        $query = "CREATE TABLE IF NOT EXISTS drivers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            username VARCHAR(191) NOT NULL UNIQUE, 
            password VARCHAR(255) NOT NULL,
            major VARCHAR(255) NOT NULL,
            homeLocation VARCHAR(255) NOT NULL,
            homeLatitude FLOAT NOT NULL,
            homeLongitude FLOAT NOT NULL,
            scheduleMonday VARCHAR(255) NOT NULL,
            scheduleTuesday VARCHAR(255) NOT NULL,
            scheduleWednesday VARCHAR(255) NOT NULL,
            scheduleThursday VARCHAR(255) NOT NULL,
            scheduleFriday VARCHAR(255) NOT NULL,
            musicTastes JSON,
            gender VARCHAR(50) NOT NULL,
            genderPreference VARCHAR(50) NOT NULL,
            phoneNumber VARCHAR(50) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";


        $this->pdo->exec($query);

        // Create passengers table
        $query = "CREATE TABLE IF NOT EXISTS passengers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            username VARCHAR(191) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            major VARCHAR(255) NOT NULL,
            homeLocation VARCHAR(255) NOT NULL,
            homeLatitude FLOAT NOT NULL,
            homeLongitude FLOAT NOT NULL,
            scheduleMonday VARCHAR(255) NOT NULL,
            scheduleTuesday VARCHAR(255) NOT NULL,
            scheduleWednesday VARCHAR(255) NOT NULL,
            scheduleThursday VARCHAR(255) NOT NULL,
            scheduleFriday VARCHAR(255) NOT NULL,
            musicTastes JSON,
            gender VARCHAR(50) NOT NULL,
            genderPreference VARCHAR(50) NOT NULL,
            phoneNumber VARCHAR(50) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        $this->pdo->exec($query);
    }
}