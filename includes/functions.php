<?php
require_once 'db_connection.php';

// Function to get all contacts
function getAllContacts($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM contacts ORDER BY last_name, first_name");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get a contact by ID
function getContactById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM contacts WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to create a new contact
function createContact($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO contacts (first_name, last_name, phone_number, email, address, city, state, zip_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    return $stmt->execute([
        $data['first_name'],
        $data['last_name'],
        $data['phone_number'],
        $data['email'],
        $data['address'],
        $data['city'],
        $data['state'],
        $data['zip_code']
    ]);
}

// Function to update a contact
function updateContact($pdo, $id, $data) {
    $stmt = $pdo->prepare("UPDATE contacts SET first_name = ?, last_name = ?, phone_number = ?, email = ?, address = ?, city = ?, state = ?, zip_code = ? WHERE id = ?");
    return $stmt->execute([
        $data['first_name'],
        $data['last_name'],
        $data['phone_number'],
        $data['email'],
        $data['address'],
        $data['city'],
        $data['state'],
        $data['zip_code'],
        $id
    ]);
}

// Function to delete a contact
function deleteContact($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM contacts WHERE id = ?");
    return $stmt->execute([$id]);
}

// Function to get all categories
function getAllCategories($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM contact_categories ORDER BY category_name");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get all incidents
function getAllIncidents($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM emergency_incidents ORDER BY date_created DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get an incident by ID
function getIncidentById($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM emergency_incidents WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to create a new incident
function createIncident($pdo, $data) {
    $stmt = $pdo->prepare("INSERT INTO emergency_incidents (incident_name, incident_type, description, location, start_date) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([
        $data['incident_name'],
        $data['incident_type'],
        $data['description'],
        $data['location'],
        $data['start_date']
    ]);
}

// Function to update an incident
function updateIncident($pdo, $id, $data) {
    $stmt = $pdo->prepare("UPDATE emergency_incidents SET incident_name = ?, incident_type = ?, description = ?, location = ?, start_date = ?, end_date = ?, status = ? WHERE id = ?");
    return $stmt->execute([
        $data['incident_name'],
        $data['incident_type'],
        $data['description'],
        $data['location'],
        $data['start_date'],
        $data['end_date'],
        $data['status'],
        $id
    ]);
}

// Function to delete an incident
function deleteIncident($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM emergency_incidents WHERE id = ?");
    return $stmt->execute([$id]);
}

// Function to get dashboard statistics
function getDashboardStats($pdo) {
    $stats = [];
    
    // Total contacts
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM contacts");
    $stmt->execute();
    $stats['total_contacts'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Total incidents
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM emergency_incidents");
    $stmt->execute();
    $stats['total_incidents'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Active incidents
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM emergency_incidents WHERE status = 'active'");
    $stmt->execute();
    $stats['active_incidents'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Total categories
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM contact_categories");
    $stmt->execute();
    $stats['total_categories'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    return $stats;
}

// Function to get recent incidents
function getRecentIncidents($pdo, $limit = 5) {
    $stmt = $pdo->prepare("SELECT * FROM emergency_incidents ORDER BY date_created DESC LIMIT " . (int)$limit);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get recent contacts
function getRecentContacts($pdo, $limit = 5) {
    $stmt = $pdo->prepare("SELECT * FROM contacts ORDER BY date_added DESC LIMIT " . (int)$limit);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get incidents by status
function getIncidentsByStatus($pdo) {
    $stmt = $pdo->prepare("SELECT status, COUNT(*) as count FROM emergency_incidents GROUP BY status");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Authentication Functions

// Function to authenticate user
function authenticateUser($pdo, $username, $password) {
    $stmt = $pdo->prepare("SELECT id, username, email, password_hash, first_name, last_name, role, is_active FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($password, $user['password_hash']) && $user['is_active']) {
        // Update last login timestamp
        $updateStmt = $pdo->prepare("UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = ?");
        $updateStmt->execute([$user['id']]);
        
        return $user;
    }
    
    return false;
}

// Function to register a new user
function registerUser($pdo, $userData) {
    // Hash the password
    $passwordHash = password_hash($userData['password'], PASSWORD_DEFAULT);
    
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash, first_name, last_name, role) VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([
        $userData['username'],
        $userData['email'],
        $passwordHash,
        $userData['first_name'],
        $userData['last_name'],
        $userData['role'] ?? 'responder'
    ]);
}

// Function to get user by ID
function getUserById($pdo, $userId) {
    $stmt = $pdo->prepare("SELECT id, username, email, first_name, last_name, role, is_active, last_login, date_created FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to create a session token
function createSessionToken($pdo, $userId) {
    // Generate a secure random token
    $token = bin2hex(random_bytes(32));
    $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));
    
    $stmt = $pdo->prepare("INSERT INTO user_sessions (user_id, session_token, expires_at) VALUES (?, ?, ?)");
    $result = $stmt->execute([$userId, $token, $expiresAt]);
    
    if ($result) {
        return $token;
    }
    
    return false;
}

// Function to validate session token
function validateSessionToken($pdo, $token) {
    $stmt = $pdo->prepare("SELECT u.id, u.username, u.email, u.first_name, u.last_name, u.role FROM user_sessions us JOIN users u ON us.user_id = u.id WHERE us.session_token = ? AND us.expires_at > NOW()");
    $stmt->execute([$token]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to destroy session
function destroySession($pdo, $token) {
    $stmt = $pdo->prepare("DELETE FROM user_sessions WHERE session_token = ?");
    return $stmt->execute([$token]);
}

// Function to destroy all sessions for a user
function destroyUserSessions($pdo, $userId) {
    $stmt = $pdo->prepare("DELETE FROM user_sessions WHERE user_id = ?");
    return $stmt->execute([$userId]);
}