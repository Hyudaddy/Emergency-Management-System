<?php
session_start();
require_once 'includes/db_connection.php';
require_once 'includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['session_token'])) {
    header('Location: login.php');
    exit();
}

// Validate session token
$user = validateSessionToken($pdo, $_SESSION['session_token']);
if (!$user) {
    header('Location: login.php');
    exit();
}

// Sample SELECT queries for demonstration
$sample_queries = [
    'Selecting All Contacts' => 'SELECT * FROM contacts;',
    'Selecting Specific Columns' => 'SELECT first_name, last_name, phone_number FROM contacts;',
    'Using WHERE Clause' => "SELECT * FROM contacts WHERE city = 'Anytown';",
    'Using ORDER BY Clause' => 'SELECT * FROM contacts ORDER BY last_name, first_name;',
    'Using DISTINCT Keyword' => 'SELECT DISTINCT city FROM contacts;',
    'Using LIMIT' => 'SELECT * FROM contacts LIMIT 5;',
    'Using LIKE Operator' => "SELECT * FROM contacts WHERE last_name LIKE 'S%';",
    'Using BETWEEN Operator' => 'SELECT * FROM contacts WHERE id BETWEEN 1 AND 3;',
    'Using IN Operator' => "SELECT * FROM contacts WHERE city IN ('Anytown', 'Othertown');",
    'Using AND/OR Conditions' => "SELECT * FROM contacts WHERE city = 'Anytown' AND state = 'CA';",
    'COUNT Function' => 'SELECT COUNT(*) AS total_contacts FROM contacts;',
    'MAX Function' => 'SELECT MAX(id) AS max_contact_id FROM contacts;',
    'MIN Function' => 'SELECT MIN(id) AS min_contact_id FROM contacts;',
    'GROUP BY' => 'SELECT city, COUNT(*) AS contact_count FROM contacts GROUP BY city;',
    'HAVING Clause' => 'SELECT city, COUNT(*) AS contact_count FROM contacts GROUP BY city HAVING COUNT(*) > 1;',
    'Using Aliases' => 'SELECT first_name AS "First Name", last_name AS "Last Name", phone_number AS "Phone" FROM contacts;'
];

// Execute a query if requested
$query_result = null;
$executed_query = '';
if (isset($_POST['query'])) {
    $executed_query = $_POST['query'];
    try {
        $stmt = $pdo->prepare($executed_query);
        $stmt->execute();
        $query_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $query_result = 'Error: ' . $e->getMessage();
    }
}

include 'includes/header.php';
?>

<div class="content-body">
    
    <!-- SELECT Queries Section -->
    
    <!-- Content Sections -->
        <!-- Query Execution Panel -->
        <div style="margin-bottom: 20px;">
            <h3 style="margin: 0 0 10px 0; color: #222; border-bottom: 2px solid #c00; padding-bottom: 5px; font-size: 18px;">QUERY EXECUTOR</h3>
            <form method="post" style="background: #f8f9fa; padding: 15px; border: 1px solid #ddd; border-radius: 0;">
                <div style="margin-bottom: 10px;">
                    <label for="custom_query" style="display: block; margin-bottom: 5px; font-weight: bold; font-size: 13px;">Enter your SQL query:</label>
                    <textarea id="custom_query" name="query" rows="4" style="width: 100%; font-family: monospace; padding: 8px; border: 1px solid #ccc; border-radius: 0; background: #fff; font-size: 13px;"><?php echo htmlspecialchars($executed_query); ?></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="padding: 8px 15px; font-size: 13px;">Execute Query</button>
            </form>
        </div>
        
        <!-- Sample Queries -->
        <div style="margin-bottom: 20px;">
            <h3 style="margin: 0 0 10px 0; color: #222; border-bottom: 2px solid #c00; padding-bottom: 5px; font-size: 18px;">SAMPLE QUERIES</h3>
            <div style="background: #f8f9fa; padding: 15px; border: 1px solid #ddd; border-radius: 0; max-height: 250px; overflow-y: auto;">
                <p style="margin: 0 0 10px 0; color: #666; font-size: 13px;">Click on any query to load it into the executor below:</p>
                
                <?php foreach ($sample_queries as $description => $query): ?>
                    <form method="post" style="margin-bottom: 10px;">
                        <p style="margin: 0 0 3px 0; font-size: 12px;"><strong><?php echo htmlspecialchars($description); ?>:</strong></p>
                        <textarea name="query" rows="2" style="width: 100%; font-family: monospace; cursor: pointer; padding: 8px; border: 1px solid #ccc; border-radius: 0; background: #fff; font-size: 12px;" readonly onclick="this.form.submit()"><?php echo htmlspecialchars($query); ?></textarea>
                    </form>
                <?php endforeach; ?>
            </div>
        </div>
        
        <!-- Query Result -->
        <div>
            <h3 style="margin: 0 0 10px 0; color: #222; border-bottom: 2px solid #c00; padding-bottom: 5px; font-size: 18px;">QUERY RESULT</h3>
            <?php if ($executed_query): ?>
                <div style="background: #f8f9fa; border: 1px solid #ddd; border-radius: 0; padding: 15px; margin-bottom: 15px;">
                    <p style="font-weight: bold; margin: 0 0 5px 0; font-size: 13px;"><strong>Executed Query:</strong></p>
                    <pre style="background: #ffffff; padding: 10px; overflow-x: auto; border: 1px solid #ddd; border-radius: 0; font-size: 12px; margin: 0;"><?php echo htmlspecialchars($executed_query); ?></pre>
                </div>
                
                <?php if (is_array($query_result)): ?>
                    <?php if (count($query_result) > 0): ?>
                        <div style="overflow-x: auto; border: 1px solid #ddd;">
                            <table class="contacts-table" style="margin: 0; font-size: 13px;">
                                <thead>
                                    <tr>
                                        <?php foreach (array_keys($query_result[0]) as $column): ?>
                                            <th style="background: #f0f0f0; padding: 8px; border-bottom: 1px solid #ddd; font-weight: bold;"><?php echo htmlspecialchars($column); ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($query_result as $row): ?>
                                        <tr>
                                            <?php foreach ($row as $value): ?>
                                                <td style="padding: 8px; border-bottom: 1px solid #eee;"><?php echo htmlspecialchars($value ?? ''); ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div style="background: #f8f9fa; border: 1px solid #ddd; border-radius: 0; padding: 15px; text-align: center;">
                            <p style="margin: 0; color: #666; font-size: 13px;">No results found.</p>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div style="background: #ffecec; border: 1px solid #f5c6cb; border-radius: 0; padding: 15px;">
                        <p style="margin: 0; color: #c00; font-size: 13px;"><?php echo htmlspecialchars($query_result); ?></p>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div style="background: #f8f9fa; border: 1px dashed #ddd; border-radius: 0; padding: 20px; text-align: center;">
                    <p style="margin: 0; color: #666; font-size: 13px;">Execute a query to see results here.</p>
                </div>
            <?php endif; ?>
        </div>
</div>

<?php
include 'includes/footer.php';
?>