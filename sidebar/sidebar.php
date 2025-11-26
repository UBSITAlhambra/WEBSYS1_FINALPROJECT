<!-- sidebar.php (Dashboard-style Sidebar) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .sidebar {
        width: 250px;
        height: 100vh;
        background: #0d6efd;
        color: white;
        position: fixed;
        left: 0;
        top: 0;
        padding: 24px 20px 20px 20px; /* Increased top padding slightly */
        display: flex;
        flex-direction: column;
        z-index: 1030; /* Ensure sidebar is above main content */
    }

    .sidebar .nav-link {
        color: rgba(255,255,255,0.9);
        margin-bottom: 8px;
        padding: 10px 15px; /* Added padding for better click area */
    }

    .sidebar .nav-link.active {
        background: rgba(255,255,255,0.25);
        border-radius: 6px;
        color: white !important;
    }

    .sidebar .nav-link:hover {
        background: rgba(255,255,255,0.2);
        border-radius: 6px;
        color: white;
    }
</style>

<aside class="sidebar">

    <h4 class="fw-bold text-white mb-4">School Clinic</h4>

    <nav class="nav flex-column">

        <a class="nav-link <?= ($activePage=='dashboard'?'active':'') ?>" 
           href="../dashboard_staff/">
            Clinic Dashboard
        </a>

        <a class="nav-link <?= ($activePage=='visits'?'active':'') ?>" 
           href="../studentRecords/">
            Student Visits
        </a>
        
        <a class="nav-link <?= ($activePage=='transactions'?'active':'') ?>" 
           href="../transaction/">
            Transactions
        </a>

        <a class="nav-link <?= ($activePage=='inventory'?'active':'') ?>" 
           href="../inventory/">
            Clinic Inventory
        </a>

        
        <a class="nav-link <?= ($activePage=='vitals'?'active':'') ?>" 
           href="../studentVital/">
            Student Vitals
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

    <div class="mt-auto text-white-50 small pt-3 border-top border-white-50">
        Logged in as: Clinic Staff
    </div>
</aside>