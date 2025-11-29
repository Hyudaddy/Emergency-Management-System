<?php
require_once '../includes/db_connection.php';
require_once '../includes/functions.php';

$message = '';
$success = false;

// Get contact ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    // Get contact info for display
    $contact = getContactById($pdo, $id);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Perform deletion
        if (deleteContact($pdo, $id)) {
            $message = 'Contact deleted successfully!';
            $success = true;
        } else {
            $message = 'Error deleting contact.';
        }
    }
} else {
    $message = 'Invalid contact ID.';
}

$page_title = 'Delete Contact - Emergency Contact System';
include '../includes/header.php';
?>

<?php if ($message): ?>
    <div class="alert <?php echo $success ? 'alert-success' : 'alert-error'; ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<?php if ($contact && !$success): ?>
    <div class="confirmation">
        <p>Are you sure you want to delete the following contact?</p>
        
        <div class="contact-details">
            <h3><?php echo htmlspecialchars($contact['first_name'] . ' ' . $contact['last_name']); ?></h3>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($contact['phone_number']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($contact['email']); ?></p>
            <p><strong>Address:</strong> <?php echo htmlspecialchars($contact['address']); ?></p>
            <p><strong>City:</strong> <?php echo htmlspecialchars($contact['city']); ?></p>
            <p><strong>State:</strong> <?php echo htmlspecialchars($contact['state']); ?></p>
            <p><strong>Zip Code:</strong> <?php echo htmlspecialchars($contact['zip_code']); ?></p>
        </div>
        
        <form method="POST" action="contacts/delete.php?id=<?php echo $contact['id']; ?>">
            <div class="form-actions">
                <button type="submit" class="btn btn-danger">Yes, Delete Contact</button>
                <a href="contacts/read.php" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
<?php elseif (!$contact && !$success): ?>
    <div class="alert alert-error">
        <p>Contact not found.</p>
    </div>
    <div class="form-actions">
        <a href="contacts/read.php" class="btn btn-secondary">Back to Contacts</a>
    </div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="form-actions">
        <a href="contacts/read.php" class="btn btn-primary">Back to Contacts</a>
    </div>
<?php endif; ?>

<?php
include '../includes/footer.php';
?>