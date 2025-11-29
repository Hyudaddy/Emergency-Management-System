<?php
echo "<h2>Path Testing</h2>";

// Test accessing the login page directly
echo "<p>Testing direct access to login.php...</p>";

// Show current directory
echo "<p>Current directory: " . getcwd() . "</p>";

// List files in current directory
echo "<p>Files in current directory:</p><ul>";
$files = scandir('.');
foreach($files as $file) {
    echo "<li>$file</li>";
}
echo "</ul>";

// Test if we can access login.php
if (file_exists('login.php')) {
    echo "<p style='color: green;'>✓ login.php exists and is accessible</p>";
} else {
    echo "<p style='color: red;'>✗ login.php NOT FOUND</p>";
}

// Test database connection file
if (file_exists('includes/db_connection.php')) {
    echo "<p style='color: green;'>✓ includes/db_connection.php exists</p>";
} else {
    echo "<p style='color: red;'>✗ includes/db_connection.php NOT FOUND</p>";
}

echo "<p><a href='login.php'>Try accessing login.php directly</a></p>";
?>