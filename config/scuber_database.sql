-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS scuber;

-- Use the scuber database
USE scuber;

-- Create drivers table
CREATE TABLE IF NOT EXISTS drivers (
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
);

-- Create passengers table
CREATE TABLE IF NOT EXISTS passengers (
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
);

-- Insert actual data for drivers
INSERT INTO drivers (id, name, username, password, major, homeLocation, homeLatitude, homeLongitude, 
                    scheduleMonday, scheduleTuesday, scheduleWednesday, scheduleThursday, scheduleFriday,
                    musicTastes, gender, genderPreference, phoneNumber, created_at) VALUES
(1, 'Raymond', 'ray', '10101010', 'Computer science', 
   'South 6th Street, St. Joseph, Champaign County, 伊利诺伊州 / 伊利諾州, 61873, 美利坚合众国/美利堅合眾國', 
   40.1119, -88.037, '09:00 AM', '09:00 AM', '09:00 AM', '09:00 AM', '09:00 AM',
   '[\"Classical\"]', 'Male', 'All', '123-456-7746', '2025-03-17 23:46:50'),
 
(2, 'Driver SCU', 'scu', '11111111', 'Computer science',
   'Santa Clara University, 500, El Camino Real, 圣克拉拉/聖塔克拉拉, Santa Clara County, 加利福尼亚州/加利福尼亞州, 95053, 美利坚合众国/美利堅合眾國',
   37.3486, -121.937, '09:00 AM', '09:00 AM', '09:00 AM', '09:00 AM', '09:00 AM',
   '[\"Hip-Hop\", \"Rock\"]', 'Other', 'All', '123-456-1233', '2025-03-18 01:01:09'),
 
(3, 'Ekam Singh', 'esingh@scu.edu', 'ekam1234', 'CSEN',
   '圣何塞机场, 1701, Airport Boulevard, North San Jose, 圣何塞, Santa Clara County, 加利福尼亚州/加利福尼亞州, 95110, 美利坚合众国/美利堅合眾國',
   37.3633, -121.929, '09:00 AM', '10:00 AM', '09:00 AM', '12:00 PM', '01:00 PM',
   '[\"Classical\", \"R&B\", \"Rock\"]', 'Male', 'All', '559-575-5679', '2025-03-18 09:46:16');

-- Insert actual data for passengers
INSERT INTO passengers (id, name, username, password, major, homeLocation, homeLatitude, homeLongitude,
                       scheduleMonday, scheduleTuesday, scheduleWednesday, scheduleThursday, scheduleFriday,
                       musicTastes, gender, genderPreference, phoneNumber, created_at) VALUES
(1, 'Raymondpass', 'raypass', '99999999', 'Computer science',
   'South 6th Street, St. Joseph, Champaign County, 伊利诺伊州 / 伊利諾州, 61873, 美利坚合众国/美利堅合眾國',
   40.1119, -88.037, '09:00 AM', '09:00 AM', '09:00 AM', '09:00 AM', '09:00 AM',
   '[\"Hip-Hop\", \"Classical\"]', 'Male', 'All', '123-456-7746', '2025-03-18 00:10:47'),
 
(2, 'Pass SCU', 'scupass', '12345678', 'Computer science',
   'Santa Clara University, 500, El Camino Real, 圣克拉拉/聖塔克拉拉, Santa Clara County, 加利福尼亚州/加利福尼亞州, 95053, 美利坚合众国/美利堅合眾國',
   37.3486, -121.937, '09:00 AM', '09:00 AM', '09:00 AM', '09:00 AM', '09:00 AM',
   '[\"Classical\", \"R&B\"]', 'Other', 'All', '123-456-1124', '2025-03-18 01:02:07'),
 
(3, 'SJC pass', 'sjc', '22222222', 'Flight',
   '圣何塞机场, 1701, Airport Boulevard, North San Jose, 圣何塞, Santa Clara County, 加利福尼亚州/加利福尼亞州, 95110, 美利坚合众国/美利堅合眾國',
   37.3633, -121.929, '09:00 AM', '10:00 AM', '09:00 AM', '12:00 PM', '01:00 PM',
   '[\"Rock\"]', 'Male', 'All', '559-575-5678', '2025-03-18 17:11:36');