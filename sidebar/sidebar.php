<?php
// Note: This sidebar is assumed to be included by files inside subdirectories 
// (e.g., studentRecords/index.php), so paths must be relative to the root.

// Load Bootstrap CSS using a RELATIVE PATH for offline availability
?>
<link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
<style>
    :root {
        --primary-maroon: #800000; /* Deep Maroon */
        --light-bg: #f8f8f8;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        background: var(--primary-maroon); 
        color: white;
        position: fixed;
        left: 0;
        top: 0;
        padding: 20px;
        display: flex;
        flex-direction: column;
        box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2);
    }

    .sidebar .nav-link {
        color: rgba(255,255,255,0.9);
        margin-bottom: 8px;
        padding: 10px 15px; 
        transition: all 0.2s;
        text-decoration: none;
    }

    .sidebar .nav-link.active {
        background: white; 
        color: var(--primary-maroon) !important;
        border-radius: 6px;
        font-weight: 600;
    }

    .sidebar .nav-link:hover {
        background: rgba(255, 255, 255, 0.15); 
        border-radius: 6px;
        color: white;
    }
    
    .sidebar .logout-link {
        color: white;
        background-color: transparent;
        border: 1px solid rgba(255, 255, 255, 0.5); 
        margin-top: auto; /* Pushes the element to the bottom */
        margin-bottom: 10px;
        padding: 10px 15px;
        border-radius: 6px;
        
        /* === NEW: Flexbox for perfect centering === */
        display: flex; /* Make it a flex container */
        justify-content: center; /* Center horizontally */
        align-items: center; /* Center vertically (though not strictly needed for single line text) */
        /* === END NEW === */
        
        transition: all 0.2s;
        font-weight: 600;
        text-decoration: none;
    }

    .sidebar .logout-link:hover {
        background-color: white; /* Color swap on hover */
        color: var(--primary-maroon);
        border-color: white;
    }
</style>

<aside class="sidebar">

    <h4 class="fw-bold text-white mb-4">School Clinic </h4>

    <nav class="nav flex-column">

        <a class="nav-link <?= ($activePage=='dashboard'?'active':'') ?>" 
           href="../dashboard_staff/">
            Clinic Dashboard
        </a>

        <a class="nav-link <?= ($activePage=='visits'?'active':'') ?>" 
           href="../studentRecords/">
            Student Visits
        </a>

        <a class="nav-link <?= ($activePage=='inventory'?'active':'') ?>" 
           href="../inventory/">
            Clinic Inventory
        </a>

        
        <a class="nav-link <?= ($activePage=='vitals'?'active':'') ?>" 
           href="../studentVital/">
            Student Vitals
        </a>
        <a class="nav-link <?= ($activePage=='transaction'?'active':'') ?>" 
           href="../transaction/">
            View Transactions
        </a>
        <a class="nav-link <?= ($activePage=='reports'?'active':'') ?>" 
           href="../report_analytics/">
            Clinic Report Summary
        </a>
        <a class="nav-link <?= ($activePage=='settings'?'active':'') ?>" 
           href="../dashboard_staff/settings.php">
            Settings
        </a>

    </nav>
    
    <?php 
    // Start session if not started (to fetch role)
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    $role = $_SESSION['role'] ?? 'Guest'; // Get the role from the session
    ?>
    
    <a class="logout-link" 
    href="../login/logout.php">
        Logout
    </a>

    <div class="text-white-50 small pt-3">
        Logged in as: <?= htmlspecialchars($role); ?>
    </div>

</aside>

<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</aside>