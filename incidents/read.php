<?php
session_start();
require_once '../includes/db_connection.php';
require_once '../includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['session_token'])) {
    header('Location: ../login.php');
    exit();
}

// Validate session token
$user = validateSessionToken($pdo, $_SESSION['session_token']);
if (!$user) {
    header('Location: ../login.php');
    exit();
}

$incidents = getAllIncidents($pdo);
$page_title = 'Incidents - Emergency Contact System';
include '../includes/header.php';
?>

<div class="actions-bar">
    <a href="create.php" class="btn btn-primary">Add New Incident</a>
</div>

<?php if (count($incidents) > 0): ?>
    <table class="contacts-table">
        <thead>
            <tr>
                <th>Incident Name</th>
                <th>Type</th>
                <th>Location</th>
                <th>Status</th>
                <th>Start Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incidents as $incident): ?>
                <tr>
                    <td><?php echo htmlspecialchars($incident['incident_name']); ?></td>
                    <td><?php echo htmlspecialchars($incident['incident_type']); ?></td>
                    <td><?php echo htmlspecialchars($incident['location']); ?></td>
                    <td><?php echo htmlspecialchars($incident['status']); ?></td>
                    <td><?php echo htmlspecialchars($incident['start_date']); ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $incident['id']; ?>" class="btn btn-small btn-secondary">Edit</a>
                        <a href="delete.php?id=<?php echo $incident['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Are you sure you want to delete this incident?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="no-data">
        <p>No incidents found. <a href="create.php">Create your first incident</a>.</p>
    </div>
<?php endif; ?>

<?php
include '../includes/footer.php';
?>