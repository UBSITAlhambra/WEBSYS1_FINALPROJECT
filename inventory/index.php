<?php
include '../login/auth_guard.php'; 
include 'oop.php';
$inventory = new oop_class();
$activePage = 'inventory';
$data = $inventory->show_data();
$page_title = 'Inventory List';

include '../sidebar/sidebar.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    <style>
    :root {
    --primary-maroon: #800000;
    --light-bg: #f8f8f8;
    --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
    --alert-bg: #ffe6e6; 
    --alert-text: #cc0000; 
}

body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: var(--light-bg);
}

.main-content {
    margin-left: 250px;
    padding: 30px 40px 0 40px;
    background: var(--light-bg);
    min-height: 100vh;
    /* Prevent the whole page from scrolling */
    overflow-y: hidden; 
}

h2 {
    margin-bottom: 26px;
    color: var(--primary-maroon);
    letter-spacing: 1px;
    text-align: center;
    font-weight: 600;
}

/* ACTION BAR */
.action-bar {
    margin: 15px auto 20px auto;
    width: 97%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

/* SEARCH & FILTER GROUP */
.search-filter-group {
    display: flex;
    gap: 10px;
    align-items: center;
    flex: 1;
}

.search-input-container {
    position: relative;
    width: 300px;
}
#search_input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 0.95rem;
    box-sizing: border-box;
}
#search_input:focus {
    outline: none;
    border-color: var(--primary-maroon);
    box-shadow: 0 0 6px rgba(128,0,0,0.3);
}

/* FILTER DROPDOWN */
#filter_status {
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 0.95rem;
    cursor: pointer;
    background-color: white;
}

/* EXPORT FORM */
.action-bar form {
    display: flex;
    align-items: center;
    gap: 8px;
}
.export-select,
.filename-input {
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 0.9rem;
    border: 1px solid #ccc;
    height: 34px;
    vertical-align: top;
}
.filename-input {
    width: 150px;
    margin-right: 10px;
    display: none;
}

/* --- SCROLLABLE TABLE STYLES --- */
.table-container {
    width: 97%;
    margin: 0 auto 18px auto;
    
    /* CALCULATION FOR 8.5 ITEMS:
       Header (~50px) + (8.5 * Row Height ~47px) ≈ 450px 
    */
    max-height: 450px; 
    
    /* Enable vertical scrolling */
    overflow-y: auto; 
    border-radius: 12px;
    box-shadow: var(--box-shadow);
    background: #fff;
}

table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
}

th, td {
    border: 1px solid #eaeaea;
    padding: 12px 12px;
    text-align: center;
    font-size: 0.95rem;
}

th {
    /* Sticky Header Logic */
    position: sticky;
    top: 0;
    z-index: 10;
    background: var(--light-bg); 
    color: var(--primary-maroon);
    font-weight: 700;
    border-bottom: 2px solid var(--primary-maroon);
    /* Add a subtle shadow to separate header from scrolling rows */
    box-shadow: 0 2px 2px -1px rgba(0,0,0,0.1); 
}

tr:nth-child(even) { background: #f7fbfc; }
tr:hover { background: #ffeaea; }

/* ALERT ROW STYLES */
.alert-row {
    background-color: var(--alert-bg) !important;
    color: var(--alert-text);
    font-weight: 600;
}
.alert-row:hover {
    background-color: #ffcccc !important; 
}

/* BUTTONS */
.btn {
    padding: 7px 16px;
    border-radius: 5px;
    font-size: 14px;
    text-decoration: none;
    color: #fff !important;
    display: inline-block;
    margin: 0 2px;
    font-weight: 600;
    transition: background 0.15s;
    border: none;
    cursor: pointer;
}
.btn.add-btn {
    background-color: var(--primary-maroon);
    color: #fff;
    margin-bottom: 0;
    margin-right: 10px;
    margin-top: 14px;
}
.btn.add-btn:hover { background-color: #a00000; }
.btn.update-btn { background-color: #2e6db4; }
.btn.update-btn:hover { background-color: #1a4d8c; }
.btn.delete-btn { background-color: #e74c3c; }
.btn.delete-btn:hover { background-color: #c0392b; }

.table-actions {
    white-space: nowrap;
    min-width: 135px;
    text-align: center;
}

@media (max-width: 900px) {
    .main-content { margin-left: 0; padding: 12px; }
    .table-container { width: 98%; }
    .action-bar { flex-direction: column; align-items: stretch; }
    .search-filter-group { flex-direction: column; width: 100%; }
    .search-input-container { width: 100%; }
}
    </style>
</head>
<body>
<div class="main-content">
    <h2>Inventory List</h2>

    <div class="action-bar">
        <div class="search-filter-group">
            <div class="search-input-container">
                <input type="text" 
                       id="search_input" 
                       placeholder="Search Name, Brand, Dosage..." 
                       autocomplete="off">
            </div>

            <select id="filter_status">
                <option value="all">Show All Status</option>
                <option value="low_stock">Low Stock (≤=25)</option>
                <option value="near_expiry">Expiring Soon (45 Days)</option>
                <option value="expired">Expired</option>
            </select>
        </div>

        <form method="GET" action="export.php">
            <input type="text" name="filename" id="filename-input" class="filename-input" placeholder="Filename (Optional)"> 
            <select name="format" id="export-format-select" class="export-select">
                <option value="csv">CSV</option>
                <option value="json">JSON</option>
                <option value="sql">SQL</option>
            </select>
            <button type="submit" class="btn update-btn" style="background-color: #555;" onclick="return confirm('Export data?');">Export</button>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Generic Name</th>
                    <th>Dosage</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Added Date</th>
                    <th>Expiry Date</th>
                    <th class="table-actions">Actions</th>
                </tr>
            </thead>
            <tbody id="inventoryTableBody">
                </tbody>
        </table>
    </div>

    <a href="add.php" class="btn add-btn">Add New Item</a>
</div>

<script type="text/javascript">
// Function to fetch data from the backend
function loadInventoryData() {
    const searchVal = document.getElementById('search_input').value;
    const filterVal = document.getElementById('filter_status').value;
    const tbody = document.getElementById('inventoryTableBody');

    // Build the URL with parameters
    const url = `fetch_inventory.php?search=${encodeURIComponent(searchVal)}&filter=${encodeURIComponent(filterVal)}`;

    fetch(url)
        .then(response => response.text())
        .then(data => {
            tbody.innerHTML = data;
        })
        .catch(error => {
            console.error('Error:', error);
            tbody.innerHTML = '<tr><td colspan="7" style="color:red;">Error loading data.</td></tr>';
        });
}

// Add Event Listeners for Live Updates
document.addEventListener('DOMContentLoaded', () => {
    // 1. Load initial data on page load
    loadInventoryData();

    // 2. Listen for typing in search box (Live Search)
    document.getElementById('search_input').addEventListener('input', loadInventoryData);

    // 3. Listen for changes in the dropdown
    document.getElementById('filter_status').addEventListener('change', loadInventoryData);

    // Export filename toggle logic
    const formatSelect = document.getElementById('export-format-select');
    const filenameInput = document.getElementById('filename-input');
    
    function toggleFilename() {
        if (formatSelect.value === 'csv' || formatSelect.value === 'sql') {
            filenameInput.style.display = 'inline-block';
        } else {
            filenameInput.style.display = 'none';
        }
    }
    formatSelect.addEventListener('change', toggleFilename);
    toggleFilename();
});

window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            window.location.reload();
        }
    });
</script>
</body>
</html>