<?php
require_once '../includes/db_connection.php';
require_once '../includes/functions.php';

$message = '';
$success = false;

// Get incident ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Get incident info for display
    $incident = getIncidentById($pdo, $id);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Perform deletion
        if (deleteIncident($pdo, $id)) {
            $message = 'Incident deleted successfully!';
            $success = true;
        } else {
            $message = 'Error deleting incident.';
        }
    }
} else {
    $message = 'Invalid incident ID.';
}

$page_title = 'Delete Incident - Emergency Contact System';
include '../includes/header.php';
?>

<?php if ($message): ?>
    <div class="alert <?php echo $success ? 'alert-success' : 'alert-error'; ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<?php if ($incident && !$success): ?>
    <div class="confirmation">
        <p>Are you sure you want to delete the following incident?</p>
        
        <div class="contact-details">
            <h3><?php echo htmlspecialchars($incident['incident_name']); ?></h3>
            <p><strong>Type:</strong> <?php echo htmlspecialchars($incident['incident_type']); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($incident['location']); ?></p>
            <p><strong>Status:</strong> <?php echo htmlspecialchars($incident['status']); ?></p>
            <p><strong>Start Date:</strong> <?php echo htmlspecialchars($incident['start_date']); ?></p>
            <p><strong>Description:</strong> <?php echo htmlspecialchars($incident['description']); ?></p>
        </div>
        
        <form method="POST" action="">
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Yes, Delete Incident</button>
                <a href="/EMERGENCY%20MANAGEMENT%20SYSTEM/incidents/read.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
<?php elseif (!$incident && !$success): ?>
    <div class="alert alert-error">
        <p>Incident not found.</p>
    </div>
    <div class="form-actions">
        <a href="/EMERGENCY%20MANAGEMENT%20SYSTEM/incidents/read.php" class="btn btn-secondary">Back to Incidents</a>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="form-actions">
        <a href="/EMERGENCY%20MANAGEMENT%20SYSTEM/incidents/read.php" class="btn btn-primary">Back to Incidents</a>
    </div>
<?php endif; ?>

<?php
include '../includes/footer.php';
?>