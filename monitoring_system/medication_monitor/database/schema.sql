CREATE DATABASE IF NOT EXISTS medication_monitor;
USE medication_monitor;

CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS medications (
    medication_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    medication_name VARCHAR(100) NOT NULL,
    dosage VARCHAR(50) NOT NULL,
    frequency VARCHAR(50) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS reminders (
    reminder_id INT AUTO_INCREMENT PRIMARY KEY,
    medication_id INT NOT NULL,
    reminder_time TIME NOT NULL,
    FOREIGN KEY (medication_id) REFERENCES medications(medication_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS logs (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    medication_id INT NOT NULL,
    log_date DATE NOT NULL,
    log_time TIME NOT NULL,
    status ENUM('taken', 'missed') NOT NULL,
    FOREIGN KEY (medication_id) REFERENCES medications(medication_id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS refill_alerts (
    alert_id INT AUTO_INCREMENT PRIMARY KEY,
    medication_id INT NOT NULL,
    alert_date DATE NOT NULL,
    FOREIGN KEY (medication_id) REFERENCES medications(medication_id) ON DELETE CASCADE
);