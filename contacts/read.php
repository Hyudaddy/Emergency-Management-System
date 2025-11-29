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

$contacts = getAllContacts($pdo);
$page_title = 'Contacts - Emergency Contact System';
include '../includes/header.php';
?>

<div class="actions-bar">
    <a href="contacts/create.php" class="btn btn-primary">Add New Contact</a>
</div>

<?php if (count($contacts) > 0): ?>
    <table class="contacts-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($contacts as $contact): ?>
                <tr>
                    <td><?php echo htmlspecialchars($contact['first_name'] . ' ' . $contact['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($contact['phone_number']); ?></td>
                    <td><?php echo htmlspecialchars($contact['email']); ?></td>
                    <td><?php echo htmlspecialchars($contact['city'] . ', ' . $contact['state']); ?></td>
                    <td>
                        <a href="contacts/update.php?id=<?php echo $contact['id']; ?>" class="btn btn-small btn-secondary">Edit</a>
                        <a href="contacts/delete.php?id=<?php echo $contact['id']; ?>" class="btn btn-small btn-danger" onclick="return confirm('Are you sure you want to delete this contact?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="no-data">
        <p>No contacts found. <a href="contacts/create.php">Create your first contact</a>.</p>
    </div>
<?php endif; ?>

<?php
include '../includes/footer.php';
?>