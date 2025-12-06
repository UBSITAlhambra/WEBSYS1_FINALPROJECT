<?php
session_start();
include 'oop.php';
$student = new oop_class();
$activePage = 'visits';
include '../sidebar/sidebar.php'; 
    if(!isset($_SESSION['user_id'])){
        header('Location: ../login/');
    }
$page_title = 'BCNHS Clinic Records';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?= $page_title ?></title>
    <style>
:root {
    --primary-maroon: #800000;
    --light-bg: #f8f8f8;
    --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
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
    /* Prevent main page scrolling */
    overflow-y: hidden;
}

h2 {
    margin-bottom: 26px;
    color: var(--primary-maroon);
    letter-spacing: 1px;
    text-align: center;
    font-weight: 600;
}

/* --- ACTION BAR & FILTERS --- */
.action-bar {
    margin: 15px auto 20px auto;
    width: 97%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.filter-group {
    display: flex;
    gap: 10px;
    align-items: center;
    flex-wrap: wrap;
    flex: 2; /* Takes up more space */
}

/* Inputs and Selects */
.search-input, .filter-select {
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 0.95rem;
    box-sizing: border-box;
}

.search-input { width: 250px; }
.filter-select { width: 150px; cursor: pointer; }

.search-input:focus, .filter-select:focus {
    outline: none;
    border-color: var(--primary-maroon);
    box-shadow: 0 0 6px rgba(128,0,0,0.3);
}

/* EXPORT FORM */
.export-form {
    display: flex;
    align-items: center;
    gap: 8px;
}
.filename-input {
    padding: 6px 10px;
    border-radius: 8px;
    font-size: 0.9rem;
    border: 1px solid #ccc;
    height: 34px;
    width: 150px;
    display: none;
}

/* --- SCROLLABLE TABLE --- */
.table-container {
    width: 97%;
    margin: 0 auto 18px auto;
    /* Max height for approx 8.5 rows */
    max-height: 450px; 
    overflow-y: auto;
    border-radius: 12px;
    background: #fff;
    box-shadow: var(--box-shadow);
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
    font-size: 0.9rem;
}

th {
    /* Sticky Headers */
    position: sticky;
    top: 0;
    z-index: 10;
    background: var(--light-bg);
    color: var(--primary-maroon);
    font-weight: 700;
    border-bottom: 2px solid var(--primary-maroon);
    box-shadow: 0 2px 2px -1px rgba(0,0,0,0.1);
}

tr:nth-child(even) { background: #f7fbfc; }
tr:hover { background: #ffeaea; }

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
    min-width: 130px;
}

@media (max-width: 900px) {
    .main-content { margin-left: 0; padding: 12px; }
    .table-container { width: 98%; }
    .action-bar { flex-direction: column; align-items: stretch; }
}
    </style>
</head>
<body>
<div class="main-content">
    
    <h2 style="margin-top: 15px;"><?= $page_title ?></h2>

    <div class="action-bar">
        <div class="filter-group">
            <input type="text" id="search_input" class="search-input" placeholder="Search Name, ID..." autocomplete="off">
            
            <select id="filter_role" class="filter-select">
                <option value="all">All Roles</option>
                <option value="Student">Student</option>
                <option value="Faculty">Faculty</option>
                <option value="Staff">Staff</option>
            </select>

            <select id="filter_dept" class="filter-select">
                <option value="all">All Depts</option>
                <option value="Grade 7">Grade 7</option>
                <option value="Grade 8">Grade 8</option>
                <option value="Grade 9">Grade 9</option>
                <option value="Grade 10">Grade 10</option>
                <option value="Grade 11">Grade 11</option>
                <option value="Grade 12">Grade 12</option>
                <option value="Faculty">Faculty Dept</option>
            </select>

            <select id="filter_complaint" class="filter-select">
                <option value="all">All Complaints</option>
                <option value="Fever">Fever</option>
                <option value="Headache">Headache</option>
                <option value="Stomach">Stomach Ache</option>
                <option value="Injury">Injury/Cut</option>
                <option value="BP">High BP</option>
            </select>
        </div>

        <form method="GET" action="export.php" class="export-form">
            <input type="text" name="filename" id="filename-input" class="filename-input" placeholder="Filename"> 
            <select name="format" id="export-format-select" class="filter-select" style="width: 100px;">
                <option value="csv">CSV</option>
                <option value="json">JSON</option>
                <option value="sql">SQL</option>
            </select>
            <button type="submit" class="btn update-btn" 
                    style="background-color: #555;" 
                    onclick="return confirm('Exporting all student records now. Continue?');">
                Export
            </button>
        </form>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>LRN</th>
                    <th>Grade & Section</th>
                    <th>Role</th>
                    <th>Complaint</th>
                    <th>Temp.</th>
                    <th>BP</th>
                    <th>Pulse</th>
                    <th>Resp. Rate</th>
                    <th>Visit Date</th>
                    <th class="table-actions">Actions</th>
                </tr>
            </thead>
            <tbody id="recordsTableBody">
                </tbody>
        </table>
    </div>
    
    <a href="add.php" class="btn add-btn">Add New Person</a>
</div>

<script type="text/javascript">
    // --- LIVE SEARCH & FILTER FUNCTION ---
    function loadRecords() {
        const search = document.getElementById('search_input').value;
        const role = document.getElementById('filter_role').value;
        const dept = document.getElementById('filter_dept').value;
        const complaint = document.getElementById('filter_complaint').value;
        const tbody = document.getElementById('recordsTableBody');

        // Build URL
        const url = `fetch_records.php?search=${encodeURIComponent(search)}&role=${encodeURIComponent(role)}&dept=${encodeURIComponent(dept)}&complaint=${encodeURIComponent(complaint)}`;

        fetch(url)
            .then(response => response.text())
            .then(data => {
                tbody.innerHTML = data;
            })
            .catch(error => console.error("Error loading records:", error));
    }

    // --- EVENT LISTENERS ---
    document.addEventListener('DOMContentLoaded', () => {
        // Load data immediately
        loadRecords();

        // Listen for Search typing
        document.getElementById('search_input').addEventListener('input', loadRecords);

        // Listen for Dropdown changes
        document.getElementById('filter_role').addEventListener('change', loadRecords);
        document.getElementById('filter_dept').addEventListener('change', loadRecords);
        document.getElementById('filter_complaint').addEventListener('change', loadRecords);

        // Export filename logic
        const formatSelect = document.getElementById('export-format-select');
        const filenameInput = document.getElementById('filename-input');
        
        function toggleFilename() {
            if (formatSelect.value === 'csv' || formatSelect.value === 'sql') {
                filenameInput.style.display = 'inline-block';
                filenameInput.setAttribute('required', 'required');
            } else {
                filenameInput.style.display = 'none';
                filenameInput.removeAttribute('required');
            }
        }
        formatSelect.addEventListener('change', toggleFilename);
        toggleFilename();
    });

    // --- DELETION POPUP LOGIC ---
    window.confirmDeletion = function(event, recordId) {
        event.preventDefault(); 
        const overlay = document.createElement('div');
        overlay.id = 'overlay';
        overlay.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999;';
        document.body.appendChild(overlay);

        const confirmationMessage = document.createElement('div');
        confirmationMessage.className = 'deletion-message';
        confirmationMessage.style.cssText = 'position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 30px; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.3); z-index: 1000; text-align: center;';
        confirmationMessage.innerHTML = `
            <p style="margin-bottom: 20px; font-weight: bold; color: #333; font-size: 1.1rem;">Are you sure you want to delete this record?</p>
            <div style="font-size: 0.9rem; margin-bottom: 20px; color: #777;">Record ID: ${recordId}</div>
            <button onclick="performDeletion('${recordId}')" style="background-color: #e74c3c; color: white; border: none; padding: 10px 20px; border-radius: 5px; margin-right: 10px; cursor: pointer;">Yes, Delete</button>
            <button onclick="closeDeletionMessage()" style="background-color: #95a5a6; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Cancel</button>
        `;
        document.body.appendChild(confirmationMessage);
        
        window.performDeletion = function(id) {
            window.location.href = `delete.php?id=${id}`;
            closeDeletionMessage();
        }

        window.closeDeletionMessage = function() {
            const msg = document.querySelector('.deletion-message');
            const ov = document.getElementById('overlay');
            if (msg) msg.remove();
            if (ov) ov.remove();
        }
        return false;
    }
</script>
</body>
</html>