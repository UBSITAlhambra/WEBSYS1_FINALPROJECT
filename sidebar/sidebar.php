
<link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
<style>
    :root {
        --primary-maroon: #800000;
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

    /* === LOGO STYLING === */
    .sidebar-logo-container {
        text-align: center;
        margin-bottom: 20px;
    }
    .sidebar-logo {
        width: 80px; /* Size of logo */
        height: auto;
        border-radius: 50%; /* Makes it circular */
        background: white; /* Adds a clean white border/background behind logo */
        padding: 5px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
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
        margin-top: auto; 
        margin-bottom: 10px;
        padding: 10px 15px;
        border-radius: 6px;
        display: flex; 
        justify-content: center; 
        align-items: center; 
        transition: all 0.2s;
        font-weight: 600;
        text-decoration: none;
    }

    .sidebar .logout-link:hover {
        background-color: white; 
        color: var(--primary-maroon);
        border-color: white;
    }
</style>

<aside class="sidebar">

    <div class="sidebar-logo-container">
        <img src="../images/logo.png" alt="School Logo" class="sidebar-logo">
    </div>

    <h5 class="fw-bold text-white mb-4 text-center">BCNHS Clinic Tracking</h5>

    <nav class="nav flex-column">
        <a class="nav-link <?= ($activePage=='dashboard'?'active':'') ?>" href="../dashboard_staff/">Clinic Dashboard</a>
        <a class="nav-link <?= ($activePage=='visits'?'active':'') ?>" href="../studentRecords/">Visits</a>
        <a class="nav-link <?= ($activePage=='transaction'?'active':'') ?>" href="../transaction/">Treatment</a>
        <a class="nav-link <?= ($activePage=='inventory'?'active':'') ?>" href="../inventory/">Clinic Inventory</a>
        <a class="nav-link <?= ($activePage=='reports'?'active':'') ?>" href="../report_analytics/">Clinic Report Summary</a>
        <a class="nav-link <?= ($activePage=='settings'?'active':'') ?>" href="../dashboard_staff/settings.php">Settings</a>
    </nav>
    
    <?php 
    if (session_status() === PHP_SESSION_NONE) { session_start(); }
    $role = $_SESSION['role'] ?? 'Guest'; 
    ?>
    
    <a class="logout-link" href="../login/logout.php">Logout</a>

    <div class="text-white-50 small pt-3 text-center">
    <br> <?php echo $_SESSION['fullname'];?><br>
    
        Logged in as: <?= htmlspecialchars($role); ?>
    </div>

</aside>

<script src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>