<?php
require_once '../includes/db_connection.php';
require_once '../includes/functions.php';

$message = '';
$contact = null;

// Get contact ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $contact = getContactById($pdo, $id);
    if (!$contact) {
        $message = 'Contact not found.';
    }
} else {
    $message = 'Invalid contact ID.';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $contact) {
    $data = [
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'phone_number' => $_POST['phone_number'],
        'email' => $_POST['email'],
        'address' => $_POST['address'],
        'city' => $_POST['city'],
        'state' => $_POST['state'],
        'zip_code' => $_POST['zip_code']
    ];
    
    if (updateContact($pdo, $id, $data)) {
        $message = 'Contact updated successfully!';
        // Refresh contact data
        $contact = getContactById($pdo, $id);
    } else {
        $message = 'Error updating contact.';
    }
}

if (!$contact && !$message) {
    $message = 'Contact not found.';
}

$page_title = 'Update Contact - Emergency Contact System';
include '../includes/header.php';
?>

<?php if ($message): ?>
    <div class="alert <?php echo strpos($message, 'Error') !== false ? 'alert-error' : 'alert-success'; ?>">
        <?php echo htmlspecialchars($message); ?>
    </div>
<?php endif; ?>

<?php if ($contact): ?>
    <form method="POST" action="update.php?id=<?php echo $contact['id']; ?>">
        <div class="form-group">
            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required value="<?php echo htmlspecialchars($contact['first_name']); ?>">
        </div>
        
        <div class="form-group">
            <label for="last_name">Last Name:</label>
            <input type="text" id="last_name" name="last_name" required value="<?php echo htmlspecialchars($contact['last_name']); ?>">
        </div>
        
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($contact['phone_number']); ?>">
        </div>
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($contact['email']); ?>">
        </div>
        
        <div class="form-group">
            <label for="address">Address:</label>
            <textarea id="address" name="address"><?php echo htmlspecialchars($contact['address']); ?></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($contact['city']); ?>">
            </div>
            
            <div class="form-group">
                <label for="state">State:</label>
                <input type="text" id="state" name="state" value="<?php echo htmlspecialchars($contact['state']); ?>">
            </div>
            
            <div class="form-group">
                <label for="zip_code">Zip Code:</label>
                <input type="text" id="zip_code" name="zip_code" value="<?php echo htmlspecialchars($contact['zip_code']); ?>">
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Contact</button>
            <a href="read.php" class="btn btn-secondary">Back to Contacts</a>
        </div>
    </form>
<?php elseif (!$message): ?>
    <div class="alert alert-error">
        <p>Contact not found.</p>
    </div>
    <div class="form-actions">
        <a href="read.php" class="btn btn-secondary">Back to Contacts</a>
    </div>
<?php endif; ?>

<?php
include '../includes/footer.php';
?>