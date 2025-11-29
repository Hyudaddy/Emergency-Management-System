<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title : 'Emergency Contact System'; ?></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        
        .main-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 220px;
            background-color: #222;
            color: #fff;
            height: 100vh;
            position: fixed;
            overflow-y: auto;
            transition: all 0.3s;
            border-right: 1px solid #444;
        }
        
        .sidebar-header {
            padding: 15px;
            background-color: #222;
            text-align: center;
            border-bottom: 1px solid #444;
        }
        
        .sidebar-header h2 {
            margin: 0;
            font-size: 1.1em;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .sidebar-menu {
            padding: 0;
            list-style: none;
        }
        
        .sidebar-menu li {
            border-bottom: 1px solid #333;
        }
        
        .sidebar-menu li a {
            display: block;
            padding: 12px 15px;
            color: #ccc;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 14px;
            font-weight: 500;
        }
        
        .sidebar-menu li a:hover,
        .sidebar-menu li a.active {
            background-color: #c00;
            color: #fff;
            border-left: 3px solid #fff;
        }
        
        .sidebar-menu li a i {
            margin-right: 8px;
            width: 20px;
            text-align: center;
            font-weight: bold;
        }
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 220px;
            padding: 15px;
        }
        
        .content-body {
            background-color: #fff;
            padding: 15px;
            border-radius: 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        
        /* User info in sidebar */
        .user-info {
            padding: 15px;
            border-bottom: 1px solid #444;
            background-color: #333;
        }
        
        .user-info .username {
            font-weight: bold;
            color: #fff;
            margin-bottom: 5px;
        }
        
        .user-info .role {
            font-size: 12px;
            color: #ccc;
        }
        
        .user-info .logout-link {
            display: block;
            margin-top: 10px;
            color: #ccc;
            text-decoration: none;
            font-size: 12px;
        }
        
        .user-info .logout-link:hover {
            color: #fff;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
            }
            
            .sidebar-header h2,
            .sidebar-menu li a span,
            .user-info .username,
            .user-info .role,
            .user-info .logout-link {
                display: none;
            }
            
            .sidebar-menu li a i {
                margin-right: 0;
                font-size: 1.2em;
            }
            
            .main-content {
                margin-left: 70px;
            }
        }
        
        /* Dashboard Styles */
        .dashboard-header {
            margin-bottom: 20px;
            border-left: 3px solid #c00;
            padding-left: 15px;
        }
        
        .dashboard-header h2 {
            color: #c00;
            margin-bottom: 5px;
            font-size: 28px;
        }
        
        .dashboard-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-card {
            background: #fff;
            color: #333;
            border: 1px solid #ddd;
            border-radius: 0;
            padding: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            transition: none;
            border-left: 3px solid #c00;
        }
        
        .stat-card:hover {
            transform: none;
            background: #f8f9fa;
        }
        
        .stat-icon {
            font-size: 1.5em;
            margin-right: 12px;
            font-weight: bold;
            color: #c00;
        }
        
        .stat-info h3 {
            font-size: 1.8em;
            margin: 0 0 3px 0;
            color: #222;
        }
        
        .stat-info p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }
        
        .dashboard-content {
            margin-bottom: 20px;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 15px;
        }
        
        .section-header {
            margin: 20px 0 15px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #c00;
        }
        
        .section-header h3 {
            color: #c00;
            margin: 0;
        }
        
        .dashboard-panel {
            background-color: #fff;
            border-radius: 0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            padding: 15px;
            border: 1px solid #ddd;
        }
        
        .dashboard-panel h3 {
            color: #222;
            margin-top: 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #c00;
            font-size: 18px;
        }
        
        .chart-container {
            height: 200px;
            position: relative;
        }
        
        .recent-list {
            max-height: 250px;
            overflow-y: auto;
        }
        
        .recent-item {
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .recent-item:last-child {
            border-bottom: none;
        }
        
        .recent-item-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3px;
        }
        
        .recent-item-header strong {
            font-size: 1em;
        }
        
        .status-badge {
            padding: 2px 6px;
            border-radius: 0;
            font-size: 0.75em;
            font-weight: bold;
        }
        
        .status-active {
            background-color: #dc3545;
            color: white;
        }
        
        .status-resolved {
            background-color: #28a745;
            color: white;
        }
        
        .status-closed {
            background-color: #6c757d;
            color: white;
        }
        
        .recent-item-details {
            display: flex;
            justify-content: space-between;
            color: #666;
            font-size: 0.85em;
        }
        
        .no-data {
            text-align: center;
            color: #666;
            font-style: italic;
            padding: 20px;
        }
        
        .quick-actions {
            display: flex;
            flex-wrap: nowrap;
            gap: 10px;
            justify-content: space-between;
            width: 100%;
            background: #fff;
            padding: 15px;
            border: 1px solid #ddd;
        }
        
        .action-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 0;
            text-decoration: none;
            color: #333;
            transition: none;
            border: 1px solid #ddd;
            border-left: 3px solid #c00;
            flex: 1;
            min-width: 100px;
            white-space: nowrap;
        }
        
        .action-card:hover {
            background-color: #e9ecef;
            transform: none;
            box-shadow: none;
        }
        
        .action-icon {
            font-size: 1.2em;
            margin-bottom: 5px;
            font-weight: bold;
            color: #c00;
        }
        
        .action-text {
            font-weight: 500;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Emergency System</h2>
            </div>
            
            <ul class="sidebar-menu">
                <li><a href="../index.php" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>"><i>⌂</i> <span>Dashboard</span></a></li>
                <li><a href="../contacts/read.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], '/contacts/') !== false) ? 'active' : ''; ?>"><i>☎</i> <span>Contacts</span></a></li>
                <li><a href="../incidents/read.php" class="<?php echo (strpos($_SERVER['PHP_SELF'], '/incidents/') !== false) ? 'active' : ''; ?>"><i>!</i> <span>Incidents</span></a></li>
                <li><a href="../query_console.php"><i>?</i> <span>Query Console</span></a></li>
            </ul>
            
            <?php if (isset($_SESSION['username'])): ?>
            <div class="user-info">
                <div class="username"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                <div class="role"><?php echo isset($_SESSION['role']) ? ucfirst($_SESSION['role']) : 'User'; ?></div>
                <a href="../logout.php" class="logout-link">Logout</a>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="content-body">