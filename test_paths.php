<?php
echo "Current working directory: " . getcwd() . "\n";
echo "PHP Self: " . $_SERVER['PHP_SELF'] . "\n";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "\n";
echo "Script Name: " . $_SERVER['SCRIPT_NAME'] . "\n";

// Test if we can include files
echo "\nTesting includes...\n";
if (file_exists('includes/db_connection.php')) {
    echo "db_connection.php exists\n";
} else {
    echo "db_connection.php NOT FOUND\n";
}

if (file_exists('includes/functions.php')) {
    echo "functions.php exists\n";
} else {
    echo "functions.php NOT FOUND\n";
}

// Test relative paths
echo "\nTesting relative paths...\n";
$relative_path = '../includes/db_connection.php';
if (file_exists($relative_path)) {
    echo "Relative path to db_connection.php works\n";
} else {
    echo "Relative path to db_connection.php FAILED\n";
}

echo "\nDirectory listing:\n";
$dirs = scandir('.');
foreach($dirs as $dir) {
    if (is_dir($dir)) {
        echo "[DIR] $dir\n";
    } else {
        echo "[FILE] $dir\n";
    }
}
?>