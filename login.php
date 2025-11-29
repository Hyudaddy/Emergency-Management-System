<?php
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id']) && isset($_SESSION['session_token'])) {
    $user = validateSessionToken($pdo, $_SESSION['session_token']);
    if ($user) {
        header('Location: index.php');
        exit();
    }
}

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (!empty($username) && !empty($password)) {
        $user = authenticateUser($pdo, $username, $password);
        
        if ($user) {
            // Create session token
            $sessionToken = createSessionToken($pdo, $user['id']);
            
            if ($sessionToken) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['session_token'] = $sessionToken;
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                
                // Redirect to dashboard
                header('Location: index.php');
                exit();
            } else {
                $error_message = 'Error creating session. Please try again.';
            }
        } else {
            $error_message = 'Invalid username or password.';
        }
    } else {
        $error_message = 'Please enter both username and password.';
    }
}

$page_title = 'Login - Emergency Contact System';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="/EMERGENCY%20MANAGEMENT%20SYSTEM/assets/css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .login-container {
            background-color: #fff;
            border-radius: 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 30px;
            width: 100%;
            max-width: 400px;
            border: 1px solid #ddd;
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 30px;
            border-left: 3px solid #c00;
            padding-left: 15px;
        }
        
        .login-header h2 {
            color: #c00;
            margin: 0 0 10px 0;
            font-size: 28px;
        }
        
        .login-header p {
            color: #666;
            margin: 0;
            font-size: 14px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #222;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 0;
            font-size: 14px;
            box-sizing: border-box;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #c00;
        }
        
        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            background-color: #c00;
            color: white;
            border: none;
            border-radius: 0;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
        
        .btn:hover {
            background-color: #a00;
        }
        
        .error-message {
            background-color: #ffecec;
            border: 1px solid #f5c6cb;
            border-radius: 0;
            padding: 10px;
            margin-bottom: 20px;
            color: #c00;
            font-size: 14px;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 13px;
        }
        
        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
        }
        
        .register-link a {
            color: #c00;
            text-decoration: none;
        }
        
        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Emergency System</h2>
            <p>Sign in to your account</p>
        </div>
        
        <?php if (!empty($error_message)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="username">Username or Email</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <button type="submit" class="btn">Sign In</button>
        </form>
        
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
        
        <div class="login-footer">
            <p>Emergency Contact Information Management System</p>
        </div>
    </div>
</body>
</html>