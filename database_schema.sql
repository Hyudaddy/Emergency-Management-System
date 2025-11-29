-- Emergency Contact Information Management System
-- Database Schema

CREATE DATABASE IF NOT EXISTS emergency_contact_system;
USE emergency_contact_system;

-- Table for storing contact information
CREATE TABLE contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    phone_number VARCHAR(20),
    email VARCHAR(100),
    address TEXT,
    city VARCHAR(50),
    state VARCHAR(50),
    zip_code VARCHAR(10),
    date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for contact categories/groups
CREATE TABLE contact_categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT
);

-- Junction table for contacts and categories (many-to-many relationship)
CREATE TABLE contact_category_assignments (
    contact_id INT,
    category_id INT,
    PRIMARY KEY (contact_id, category_id),
    FOREIGN KEY (contact_id) REFERENCES contacts(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES contact_categories(id) ON DELETE CASCADE
);

-- Table for communication methods
CREATE TABLE communication_methods (
    id INT AUTO_INCREMENT PRIMARY KEY,
    method_name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT
);

-- Table for contact communication preferences
CREATE TABLE contact_communication_preferences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT,
    method_id INT,
    priority_level INT,
    is_primary BOOLEAN DEFAULT FALSE,
    notes TEXT,
    FOREIGN KEY (contact_id) REFERENCES contacts(id) ON DELETE CASCADE,
    FOREIGN KEY (method_id) REFERENCES communication_methods(id) ON DELETE CASCADE
);

-- Table for emergency incidents/events
CREATE TABLE emergency_incidents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    incident_name VARCHAR(100) NOT NULL,
    incident_type VARCHAR(50),
    description TEXT,
    location VARCHAR(100),
    start_date DATETIME,
    end_date DATETIME,
    status ENUM('active', 'resolved', 'closed') DEFAULT 'active',
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for contact interaction logs
CREATE TABLE contact_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT,
    incident_id INT,
    interaction_date DATETIME,
    communication_method VARCHAR(50),
    notes TEXT,
    status ENUM('attempted', 'successful', 'failed') DEFAULT 'attempted',
    follow_up_required BOOLEAN DEFAULT FALSE,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contact_id) REFERENCES contacts(id) ON DELETE CASCADE,
    FOREIGN KEY (incident_id) REFERENCES emergency_incidents(id) ON DELETE SET NULL
);

-- Table for system users (administrators/responders)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    role ENUM('admin', 'responder', 'viewer') DEFAULT 'responder',
    is_active BOOLEAN DEFAULT TRUE,
    last_login TIMESTAMP NULL,
    date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for user sessions
CREATE TABLE user_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    session_token VARCHAR(255) NOT NULL UNIQUE,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);