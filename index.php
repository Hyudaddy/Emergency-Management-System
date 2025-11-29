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

$page_title = 'Dashboard - Emergency Contact System';

// Get dashboard statistics
$stats = getDashboardStats($pdo);
$recent_incidents = getRecentIncidents($pdo);
$recent_contacts = getRecentContacts($pdo);
$incidents_by_status = getIncidentsByStatus($pdo);

include 'includes/header.php';
?>

<div class="dashboard-header">
    <h2>Emergency Management Dashboard</h2>
    <p>Welcome to the Emergency Contact Information Management System</p>
</div>

<!-- Stats Cards -->
<div class="dashboard-stats">
    <div class="stat-card">
        <div class="stat-icon">☎</div>
        <div class="stat-info">
            <h3><?php echo $stats['total_contacts']; ?></h3>
            <p>Total Contacts</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">!</div>
        <div class="stat-info">
            <h3><?php echo $stats['total_incidents']; ?></h3>
            <p>Total Incidents</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">⚡</div>
        <div class="stat-info">
            <h3><?php echo $stats['active_incidents']; ?></h3>
            <p>Active Incidents</p>
        </div>
    </div>
    
</div>

<!-- Charts and Recent Activity -->
<div class="dashboard-content">
    <div class="dashboard-grid">
        <!-- Incident Status Chart -->
        <div class="dashboard-panel">
            <h3>Incidents by Status</h3>
            <div class="chart-container">
                <canvas id="incidentStatusChart"></canvas>
            </div>
        </div>
        
        <!-- Recent Incidents -->
        <div class="dashboard-panel">
            <h3>Recent Incidents</h3>
            <?php if (count($recent_incidents) > 0): ?>
                <div class="recent-list">
                    <?php foreach ($recent_incidents as $incident): ?>
                        <div class="recent-item">
                            <div class="recent-item-header">
                                <strong><?php echo htmlspecialchars($incident['incident_name']); ?></strong>
                                <span class="status-badge status-<?php echo $incident['status']; ?>"><?php echo ucfirst($incident['status']); ?></span>
                            </div>
                            <div class="recent-item-details">
                                <span><?php echo htmlspecialchars($incident['incident_type']); ?></span>
                                <span><?php echo date('M j, Y', strtotime($incident['start_date'])); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-data">No incidents found.</p>
            <?php endif; ?>
        </div>
        
        <!-- Recent Contacts -->
        <div class="dashboard-panel">
            <h3>Recently Added Contacts</h3>
            <?php if (count($recent_contacts) > 0): ?>
                <div class="recent-list">
                    <?php foreach ($recent_contacts as $contact): ?>
                        <div class="recent-item">
                            <div class="recent-item-header">
                                <strong><?php echo htmlspecialchars($contact['first_name'] . ' ' . $contact['last_name']); ?></strong>
                            </div>
                            <div class="recent-item-details">
                                <span><?php echo htmlspecialchars($contact['phone_number']); ?></span>
                                <span><?php echo htmlspecialchars($contact['city'] . ', ' . $contact['state']); ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="no-data">No contacts found.</p>
            <?php endif; ?>
        </div>
        
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Incident Status Chart
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('incidentStatusChart').getContext('2d');
    
    // Prepare data
    var statusData = {
        active: 0,
        resolved: 0,
        closed: 0
    };
    
    // Fill with actual data
    <?php foreach ($incidents_by_status as $status): ?>
        statusData.<?php echo $status['status']; ?> = <?php echo $status['count']; ?>;
    <?php endforeach; ?>
    
    var chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Active', 'Resolved', 'Closed'],
            datasets: [{
                data: [statusData.active, statusData.resolved, statusData.closed],
                backgroundColor: [
                    '#dc3545',
                    '#28a745',
                    '#6c757d'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>

<?php
include 'includes/footer.php';
?>