<?php
require_once '../includes/db_connection.php';
require_once '../includes/functions.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'incident_name' => $_POST['incident_name'],
        'incident_type' => $_POST['incident_type'],
        'description' => $_POST['description'],
        'location' => $_POST['location'],
        'start_date' => $_POST['start_date']
    ];
    
    if (createIncident($pdo, $data)) {
        $message = 'Incident created successfully!';
        // Clear form data
        $_POST = [];
    } else {
        $message = 'Error creating incident.';
    }
}

$page_title = 'Create Incident - Emergency Contact System';
include '../includes/header.php';
?>

<?php if ($message): ?>
    <div class="alert <?php echo strpos($message, 'Error') !== false ? 'alert-error' : 'alert-success'; ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<form method="POST" action="">
    <div class="form-group">
        <label for="incident_name">Incident Name:</label>
        <input type="text" id="incident_name" name="incident_name" required value="<?php echo isset($_POST['incident_name']) ? htmlspecialchars($_POST['incident_name']) : ''; ?>">
    </div>
    
    <div class="form-group">
        <label for="incident_type">Incident Type:</label>
        <input type="text" id="incident_type" name="incident_type" required value="<?php echo isset($_POST['incident_type']) ? htmlspecialchars($_POST['incident_type']) : ''; ?>">
    </div>
    
    <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" required value="<?php echo isset($_POST['location']) ? htmlspecialchars($_POST['location']) : ''; ?>">
    </div>
    
    <div class="form-group">
        <label for="start_date">Start Date:</label>
        <input type="datetime-local" id="start_date" name="start_date" value="<?php echo isset($_POST['start_date']) ? htmlspecialchars($_POST['start_date']) : ''; ?>">
    </div>
    
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="4"><?php echo isset($_POST['description']) ? htmlspecialchars($_POST['description']) : ''; ?></textarea>
    </div>
    
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Create Incident</button>
        <a href="/EMERGENCY%20MANAGEMENT%20SYSTEM/incidents/read.php" class="btn btn-secondary">Back to Incidents</a>
    </div>
</form>

<?php
include '../includes/footer.php';
?>