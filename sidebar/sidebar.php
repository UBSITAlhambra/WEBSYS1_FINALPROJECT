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
        padding: 20px;
        display: flex;
        flex-direction: column;
    }

    .sidebar .nav-link {
        color: rgba(255,255,255,0.9);
        margin-bottom: 8px;
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
           Dashboard
        </a>

        <a class="nav-link <?= ($activePage=='visits'?'active':'') ?>" 
           href="../studentRecords/">
           Visits
        </a>

        <a class="nav-link <?= ($activePage=='inventory'?'active':'') ?>" 
           href="../inventory/">
           Inventory
        </a>

        <a class="nav-link <?= ($activePage=='vitals'?'active':'') ?>" 
           href="../studentVital/">
           Vitals
        </a>
        <a class="nav-link <?= ($activePage=='settings'?'active':'') ?>" 
           href="../dashboard_staff/settings.php">
           Settings
        </a>

    </nav>

    <div class="mt-auto text-white-50 small pt-3">
        Logged in as: Clinic Staff
    </div>

</aside>
