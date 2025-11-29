<?php
$page_title = 'Dashboard - Emergency Contact System';
include 'includes/header.php';
?>

<div class="dashboard">
    <h2>System Dashboard</h2>
    
    <div class="dashboard-sections">
        <div class="dashboard-card">
            <h3>Contacts Management</h3>
            <p>Manage emergency contact information including names, phone numbers, emails, and addresses.</p>
            <div class="actions">
                <a href="contacts/read.php" class="btn btn-primary">View Contacts</a>
                <a href="contacts/create.php" class="btn btn-secondary">Add New Contact</a>
            </div>
        </div>
        
        <div class="dashboard-card">
            <h3>Incident Management</h3>
            <p>Track and manage emergency incidents including details, status, and response information.</p>
            <div class="actions">
                <a href="incidents/read.php" class="btn btn-primary">View Incidents</a>
                <a href="incidents/create.php" class="btn btn-secondary">Add New Incident</a>
            </div>
        </div>
        
        <div class="dashboard-card">
            <h3>Communication Logs</h3>
            <p>Track communication attempts with contacts during emergency situations.</p>
            <div class="actions">
                <a href="#" class="btn btn-primary">View Logs</a>
                <a href="#" class="btn btn-secondary">Add Log Entry</a>
            </div>
        </div>
        
        <div class="dashboard-card">
            <h3>Reports & Analytics</h3>
            <p>Generate reports on contacts, incidents, and communication effectiveness.</p>
            <div class="actions">
                <a href="#" class="btn btn-primary">Generate Reports</a>
                <a href="#" class="btn btn-secondary">View Analytics</a>
            </div>
        </div>
    </div>
</div>

<div class="system-info">
    <h3>About This System</h3>
    <p>This Emergency Contact Information Management System is designed to help disaster response teams maintain up-to-date contact information for critical personnel and track communication during emergency situations.</p>
    
    <h3>Key Features</h3>
    <ul>
        <li>Store and manage contact information for emergency responders</li>
        <li>Organize contacts by category (First Responders, Medical Personnel, etc.)</li>
        <li>Track emergency incidents and their status</li>
        <li>Log communication attempts with contacts</li>
        <li>Generate reports for situational awareness</li>
    </ul>
</div>

<?php
include 'includes/footer.php';
?>