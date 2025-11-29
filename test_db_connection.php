<?php
require_once 'includes/db_connection.php';

try {
    // Test the connection by running a simple query
    $stmt = $pdo->query("SELECT COUNT(*) FROM contacts");
    $count = $stmt->fetchColumn();
    echo "Database connection successful! Found {$count} contacts in the database.";
} catch (PDOException $e) {
    echo "Database test failed: " . $e->getMessage();
}
?>