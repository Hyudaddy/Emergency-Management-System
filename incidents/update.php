<?php
require_once '../includes/db_connection.php';
require_once '../includes/functions.php';

$message = '';
$incident = null;

// Get incident ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $incident = getIncidentById($pdo, $id);
    if (!$incident) {
        $message = 'Incident not found.';
    }
} else {
    $message = 'Invalid incident ID.';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $incident) {
    $data = [
        'incident_name' => $_POST['incident_name'],
        'incident_type' => $_POST['incident_type'],
        'description' => $_POST['description'],
        'location' => $_POST['location'],
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date'],
        'status' => $_POST['status']
    ];
    
    if (updateIncident($pdo, $id, $data)) {
        $message = 'Incident updated successfully!';
        // Refresh incident data
        $incident = getIncidentById($pdo, $id);
    } else {
        $message = 'Error updating incident.';
    }
}

if (!$incident && !$message) {
    $message = 'Incident not found.';
}

$page_title = 'Update Incident - Emergency Contact System';
include '../includes/header.php';
?>

<?php if ($message): ?>
    <div class="alert <?php echo strpos($message, 'Error') !== false ? 'alert-error' : 'alert-success'; ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<?php if ($incident): ?>
    <form method="POST" action="incidents/update.php?id=<?php echo $incident['id']; ?>">
        <div class="form-group">
            <label for="incident_name">Incident Name:</label>
            <input type="text" id="incident_name" name="incident_name" required value="<?php echo htmlspecialchars($incident['incident_name']); ?>">
        </div>
        
        <div class="form-group">
            <label for="incident_type">Incident Type:</label>
            <input type="text" id="incident_type" name="incident_type" required value="<?php echo htmlspecialchars($incident['incident_type']); ?>">
        </div>
        
        <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" required value="<?php echo htmlspecialchars($incident['location']); ?>">
        </div>
        
        <div class="form-group">
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="active" <?php echo $incident['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                <option value="resolved" <?php echo $incident['status'] == 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                <option value="closed" <?php echo $incident['status'] == 'closed' ? 'selected' : ''; ?>>Closed</option>
            </select>
        </div>
        
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="datetime-local" id="start_date" name="start_date" value="<?php echo htmlspecialchars(substr($incident['start_date'], 0, 16)); ?>">
        </div>
        
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="datetime-local" id="end_date" name="end_date" value="<?php echo $incident['end_date'] ? htmlspecialchars(substr($incident['end_date'], 0, 16)) : ''; ?>">
        </div>
        
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($incident['description']); ?></textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Incident</button>
            <a href="incidents/read.php" class="btn btn-secondary">Back to Incidents</a>
        </div>
    </form>
<?php elseif (!$message): ?>
    <div class="alert alert-error">
        <p>Incident not found.</p>
    </div>
    <div class="form-actions">
        <a href="incidents/read.php" class="btn btn-secondary">Back to Incidents</a>
    </div>
<?php endif; ?>

<?php
include '../includes/footer.php';
?>