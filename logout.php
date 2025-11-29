<?php
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

session_start();

// Destroy session in database if token exists
if (isset($_SESSION['session_token'])) {
    destroySession($pdo, $_SESSION['session_token']);
}

// Destroy PHP session
session_destroy();

// Redirect to login page
header('Location: login.php');
exit();