<?php
    // Assume 'oop.php' and 'sidebar/sidebar.php' are correctly defined in the execution environment
include 'oop.php';
    // The class is named 'oop_class' in the original code, and used to fetch inventory data here.
$inventory = new oop_class();
    $activePage = 'inventory';
    include '../sidebar/sidebar.php'; 

    $searchTerm = $_GET['search'] ?? '';
    $page_title = 'Inventory List';

    if (!empty($searchTerm)) {
        $data = $inventory->search_inventory($searchTerm); 
        $page_title = 'Search Results for: ' . htmlspecialchars($searchTerm);
    } else {
        $data = $inventory->show_data();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory List</title>
    <style>
        /* CSS Variables matching the Login/Register aesthetic */
        :root {
            --primary-maroon: #800000;
            --light-bg: #f8f8f8;
            --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            --header-bg: #fff;
            --secondary-text: #555;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--light-bg);
        }

        /* Adjusting for sidebar inclusion (assuming sidebar is around 250px wide) */
        .main-content {
            margin-left: 250px;
            padding: 30px 40px 0 40px;
            background: var(--light-bg);
            min-height: 100vh;
        }
        
        /* Header and Actions */
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            padding: 15px;
            background: var(--header-bg);
            border-radius: 12px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .title {
            margin: 0;
            color: var(--primary-maroon);
            font-size: 24px;
            font-weight: 600;
        }

        .search-input {
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            width: 300px;
            transition: all 0.3s;
        }
        .search-input:focus {
            border-color: var(--primary-maroon);
            box-shadow: 0 0 0 3px rgba(128, 0, 0, 0.1);
            outline: none;
        }

        /* Table Design */
        .table-container {
            overflow-x: auto;
            border-radius: 12px;
            box-shadow: var(--box-shadow);
        }

        table {
            width: 100%; 
            border-collapse: collapse;
            margin: 0;
            background: #fff;
            min-width: 1000px; /* Ensure table doesn't compress too much */
        }

        th, td {
            border: 1px solid #e0e0e0; /* Lighter border */
            padding: 14px 15px; /* Increased padding */
            text-align: left; 
            font-size: 0.9rem;
        }
        
        td {
            color: var(--secondary-text);
        }

        th {
            background: var(--primary-maroon);
            color: #fff;
            font-weight: 600;
            border-bottom: 2px solid var(--primary-maroon);
            text-align: center; /* Center header text */
        }
        
        th:first-child, td:first-child {
            text-align: left;
        }
        th:last-child, td:last-child {
            text-align: center;
        }
        tr:nth-child(even) {
            background: #fefefe;
        } /* Lighter striping */
        tr:hover {
            background: #fff5f5;
        }
        .table-actions {
            white-space: nowrap;
            min-width: 135px;
        }

        /* Buttons */
        .btn {
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 13px;
            text-decoration: none;
            color: #fff !important;
            display: inline-block;
            margin: 0 4px;
            font-weight: 600;
            transition: all 0.2s ease-in-out;
            border: none;
            cursor: pointer;
            text-transform: uppercase;
        }

        .btn.add-btn {
            background-color: var(--primary-maroon);
            box-shadow: 0 4px #a00000;
        }
        .btn.add-btn:hover { 
            background-color: #a00000; 
            transform: translateY(-1px);
            box-shadow: 0 5px #7a0000;
        }
        .btn.add-btn:active {
            transform: translateY(2px);
            box-shadow: 0 2px #7a0000;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 6px; 
        }
        
        .btn-group .btn {
            margin: 0;
            padding: 6px 12px;
            font-size: 12px;
            border-radius: 5px;
        }

        .btn.update-btn {
            background-color: #2e6db4;
        }
        .btn.update-btn:hover {
            background-color: #1a4d8c;
        }

        .btn.delete-btn {
            background-color: #e74c3c;
        }
        .btn.delete-btn:hover {
            background-color: #c0392b;
        }
        
        .table-actions {
            padding: 0;
            margin: 0;
            text-align: center;
        }

        .no-records {
            background: #fff0f0;
            color: var(--primary-maroon);
            font-weight: bold;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: var(--box-shadow);
        }
        @media (max-width: 1200px) {
            .main-content { margin-left: 0; padding: 20px; }
            .header-actions { flex-direction: column; align-items: flex-start; }
            .title { margin-bottom: 15px; }
            .search-input { width: 100%; }
        }
        
        @media (max-width: 600px) {
            .table-container { 
                overflow-x: auto;
            }
            table {
                min-width: 800px;
            }
            .btn.add-btn {
                width: 100%;
                text-align: center;
                margin: 10px 0;
            }
        }
        .add-btn:hover {
            background-color: #178347;
        }
        .update-btn {
            background-color: #298afc;
        }
        .update-btn:hover {
            background-color: #1765b8;
        }
        .delete-btn {
            background-color: #fb2555;
        }
        .delete-btn:hover {
            background-color: #ab092e;
        }
        .action-bar {
            margin: 15px 0 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 98%;
            margin-left: auto;
            margin-right: auto;
        }
        .search-input-container{
            position: relative;
            width: 500px;
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
        #searchResultArea table {
            margin: 0;
            width: 100%;
            border-collapse: collapse;
        }
        #searchResultArea td {
            border: none;
            padding: 6px 8px;
            cursor: pointer;
            font-size: 12px;
        }
        #searchResultArea tr:hover {
            background-color: #e9e9e9;
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
        
        @media (max-width: 900px) {
            .main-content {
                margin-left: 0;
                padding: 12px;
            } table {
                width: 98%;
            }
        }
    </style>

    <script type="text/javascript">
        function showSearchRecord(term) {
            const query = term.trim(); 
            const resultsArea = document.getElementById("searchResultArea");
            if (query === "") { resultsArea.innerHTML = ""; return; }
            const url = "getSearch.php?search_term=" + encodeURIComponent(query);
            fetch(url).then(response => response.text()).then(data => resultsArea.innerHTML = data).catch(error => console.error("Fetch Error:", error));
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

<div class="main-content">
    <h2><?= $page_title ?></h2>

    <div class="action-bar">
        <div class="search-input-container">
            <input type="text" 
                   id="search_input" 
                   name="search"
                   placeholder="Search by Name, Brand, Dosage, or Category..." 
                   value="<?= htmlspecialchars($searchTerm) ?>"
                   oninput="showSearchRecord(this.value);" 
                   onkeydown="handleSearchKeyPress(event);"
                   autocomplete="off">

            <div id="searchResultArea"></div>
        </div>
        <form method="GET" action="export.php" style="display: inline-block;">
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
            <button type="submit" class="btn update-btn" 
                    style="background-color: #555;" 
                    onclick="return confirm('Exporting all inventory records now. Continue?');">
                Export Data
            </button>
        </form>
        </div>
    <?php if (!empty($searchTerm)): ?>
        <div style="margin-bottom: 15px; width: 98%; margin-left: auto; margin-right: auto; text-align: left;">
            <a href="index.php" class="btn delete-btn">Clear Search</a>
        </div>
    <?php endif; ?>

    <?php if (empty($data) && !empty($searchTerm)): ?>
        <div style="padding: 50px; text-align: center;">
            <h1>No Results Found for "<?= htmlspecialchars($searchTerm) ?>"</h1>
            <p>Please try a different search term or <a href="index.php">clear the search filter</a></p>
        </div>
    <?php else: ?>
        <table>
            <tr>
                <th>Generic Name</th>
                <th>Dosage</th>
                <th>Brand</th>
                <th>Quantity</th>
                <th>Category</th>
                <th>Added Date</th>
                <th>Expiry Date</th>
                <th class="table-actions">Actions</th>
            </tr>
            <?php if (count($data) > 0): ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['genericName']) ?></td>
                        <td><?= htmlspecialchars($row['dosage']) ?></td>
                        <td><?= htmlspecialchars($row['brand']) ?></td>
                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                        <td><?= htmlspecialchars($row['category']) ?></td>
                        <td><?= htmlspecialchars($row['addDate']) ?></td>
                        <td><?= htmlspecialchars($row['expDate']) ?></td>
                        <td class="table-actions">
                            <a href="update.php?id=<?= $row['itemID'] ?>" class="btn update-btn">Update</a>
                            <a href="delete.php?id=<?= $row['itemID'] ?>" class="btn delete-btn"
                               onclick="return confirm('Are you sure you want to delete this item?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" style="color:#b53d3d;font-weight:bold;">No inventory data found.</td>
                </tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>

    <a href="add.php" class="btn add-btn">➕ Add New Item</a>
    <a href="#" class="btn add-btn">Home</a>
</div>
</body>
</html>