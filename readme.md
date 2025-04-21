# Scuber

This is the final project for Coen160 (Web Design)

# Scuber Project Database Setup

This project uses MySQL as its database. Follow these instructions to set up the database on your system.

## Prerequisites

- MySQL Server installed (version 5.7+ recommended)
- phpMyAdmin (since I'm using wamp, this is helpful to me)
- ## folder has to be directly under localhost, and with the coen161/scuber. Correct path: `http://localhost/coen161/scuber/`
  
  without the correct path the program will not run

## Database Setup Instructions

### Option 1: Using phpMyAdmin

1. Open phpMyAdmin
2. Click on the "Import" tab at the top
3. Click "Choose File" and select the included `scuber_database.sql` file from config folder (same folder as `database.php`)
4. Click "Go" at the bottom to execute the import

### Option 2: Using MySQL Command Line

1. Open a terminal or command prompt
2. Log in to MySQL:
   
   ```
   mysql -u root -p
   ```
   
   (Enter your MySQL root password when prompted)
3. Run the following command to import the database:
   
   ```
   source /path/to/scuber_database.sql
   ```
   
   (Replace `/path/to/` with the actual path to the SQL file)

## Database Configuration

If you need to modify the database connection settings for the application, please update the following parameters in the `database.php` file:

```php
private $host = 'localhost';
private $db_name = 'scuber';
private $username = 'root'; // Change to your MySQL username
private $password = ''; // Change to your MySQL password
```

## Sample Data

The SQL script includes sample data for:

- 3 drivers
- 3 passengers

You can view this data by running:

```sql
SELECT * FROM drivers;
SELECT * FROM passengers;
```

## Checking if database is connected:

you can go to `http://localhost/coen161/scuber/test.php`to see if it is working
