<?php
session_start();
include "oop.php";
$oop = new oop_class();
$activePage = 'transactions';
include '../sidebar/sidebar.php';
    if(!isset($_SESSION['user_id'])){
        header('Location: ../login/');
    }
$searchTerm = $_GET['search'] ?? '';
$page_title = 'Treatment Records';

if (!empty($searchTerm)) {
    $data = $oop->search_transactions_by_name($searchTerm); // array
    $page_title = 'Search Results for: ' . htmlspecialchars($searchTerm);
} else {
    $data = $oop->show_data(); // array
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
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
        }
        
        h2 {
            text-align: center;
            margin-bottom: 26px;
            color: var(--primary-maroon);
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        table {
            width: 95%;
            border-collapse: collapse;
            margin: 0 auto 18px auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--box-shadow);
        }
        
        th, td {
            border: 1px solid #eaeaea;
            padding: 12px 12px;
            text-align: left;
            font-size: 0.95rem;
        }
        
        th {
            background: var(--light-bg);
            color: var(--primary-maroon);
            font-weight: 700;
            border-bottom: 2px solid var(--primary-maroon);
            text-align: center;
        }
        
        tr:nth-child(even) { background: #f7fbfc; }
        tr:hover { background: #ffeaea; }
        
        .btn {
            padding: 7px 14px;
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
        
        .btn.update { background: #2e6db4; }
        .btn.update:hover { background: #1a4d8c; }
        
        .btn.delete { background: #e74c3c; }
        .btn.delete:hover { background: #c0392b; }
        
        .btn.add-btn {
            background-color: var(--primary-maroon);
            color: #fff;
            margin-bottom: 0;
            margin-right: 8px;
            margin-top: 14px;
            font-size: 15px;
        }
        .btn.add-btn:hover {
            background-color: #a00000;
        }

        .action-bar {
            margin: 15px 0 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 95%;
            margin-left: auto;
            margin-right: auto;
        }

        .search-input-container {
            position: relative;
            width: 400px;
            margin: 0;
        }
        #search_input {
            width: 100%;
            padding: 8px;
            border: 1px solid #999;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        #searchResultArea {
            position: absolute;
            width: 100%;
            top: 100%;
            z-index: 1000;
            background: #fff;
            border: 1px solid #999;
            border-top: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .action-bar form {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .export-select {
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 15px;
            border: 1px solid #ccc;
            height: 34px;
            vertical-align: top;
        }

        .filename-input {
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 15px;
            border: 1px solid #ccc;
            height: 32px;
            vertical-align: top;
            width: 150px;
            margin-right: 10px;
            display: none;
        }

        .table-actions {
            white-space: nowrap;
            min-width: 120px;
            text-align: center;
        }
        
        @media (max-width: 900px) {
            .main-content {
                margin-left: 0;
                padding: 12px;
            }
            table {
                width: 98%;
            }
            .action-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
        }
    </style>

    <script type="text/javascript">
        function showSearchRecord(term) {
            const query = term.trim(); 
            const resultsArea = document.getElementById("searchResultArea");
            if (query === "") { resultsArea.innerHTML = ""; return; }
            const url = "getSearch.php?search_term=" + encodeURIComponent(query);
            fetch(url)
                .then(response => response.text())
                .then(data => resultsArea.innerHTML = data)
                .catch(error => console.error("Fetch Error:", error));
        }
        function executeSearch(query) {
            window.location.href = "index.php?search=" + encodeURIComponent(query.trim());
        }
        function getData(name) {
            document.getElementById("search_input").value = name;
            document.getElementById("searchResultArea").innerHTML = ""; 
            executeSearch(name); 
        }
        function handleSearchKeyPress(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); 
                const query = document.getElementById("search_input").value;
                if (query.trim() !== "") { executeSearch(query); }
            }
        }
        function toggleFilenameVisibility() {
            const formatSelect = document.getElementById('export-format-select');
            const filenameInput = document.getElementById('filename-input');
            const selectedFormat = formatSelect.value;
            if (selectedFormat === 'csv' || selectedFormat === 'sql') {
                filenameInput.style.display = 'inline-block'; 
            } else {
                filenameInput.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const formatSelect = document.getElementById('export-format-select');
            formatSelect.addEventListener('change', toggleFilenameVisibility);
            toggleFilenameVisibility();
        });
    </script>
</head>
<body>
<div class="main-content">
    <h2><?= $page_title ?></h2>

    <div class="action-bar">
        <div class="search-input-container">
            <input type="text" 
                   id="search_input" 
                   name="search"
                   placeholder="Search by Medicine, Student, or ID..." 
                   value="<?= htmlspecialchars($searchTerm) ?>"
                   oninput="showSearchRecord(this.value);" 
                   onkeydown="handleSearchKeyPress(event);"
                   autocomplete="off">
            <div id="searchResultArea"></div>
        </div>
        <form method="GET" action="export.php">
            <input type="text" 
                   name="filename" 
                   id="filename-input"
                   class="filename-input" 
                   placeholder="Optional Filename"> 
            <select name="format" id="export-format-select" class="export-select">
                <option value="csv">CSV (Spreadsheet)</option>
                <option value="json">JSON (Data)</option>
                <option value="sql">SQL (Database)</option>
            </select>
            <button type="submit" class="btn update" 
                    style="background-color: #555;" 
                    onclick="return confirm('Exporting all transaction records now. Continue?');">
                Export Data
            </button>
        </form>
    </div>

    <?php if (!empty($searchTerm)): ?>
        <div style="margin-bottom: 15px; width: 95%; margin-left: auto; margin-right: auto; text-align: left;">
            <a href="index.php" class="btn delete">Clear Search</a>
        </div>
    <?php endif; ?>

    <?php if (empty($data) && !empty($searchTerm)): ?>
        <div style="padding: 50px; text-align: center;">
            <h1>No Treatment Records Found for "<?= htmlspecialchars($searchTerm) ?>"</h1>
            <p>Please try a different search term or <a href="index.php">clear the search filter</a></p>
        </div>
    <?php else: ?>
        <table>
            <tr>
                <th>Medicine</th>
                <th>Student</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Remarks</th>
                <th class="table-actions">Action</th>
            </tr>
            <?php if (!empty($data)): ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['medicineName'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['studentName'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['quantity'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['transactionDate'] ?? '') ?></td>
                        <td><?= htmlspecialchars($row['remarks'] ?? '') ?></td>
                        <td>
                            <a class="btn update" href="update.php?id=<?= $row['transactionID']; ?>">Edit</a>
                            <a class="btn delete"
                               href="delete.php?id=<?= $row['transactionID']; ?>"
                               onclick="return confirm('Delete this record?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6" style="color:#b53d3d;font-weight:bold;">No Treatment Records Found.</td></tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>

    <a href="add.php" class="btn add-btn">Add New Treatment</a>
</div>
</body>
</html>
