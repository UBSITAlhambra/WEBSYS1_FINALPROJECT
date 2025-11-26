<?php
    include "oop.php";
    $oop = new oop_class();
    $activePage = 'transactions';
    include '../sidebar/sidebar.php';
    $searchTerm = $_GET['search'] ?? '';
    $page_title = 'Transaction Records';

    if (!empty($searchTerm)) {
        $data = $oop->search_transactions_by_name($searchTerm); 
        $page_title = 'Search Results for: ' . htmlspecialchars($searchTerm);
    } else {
        $data = $oop->show_data();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $page_title ?></title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #fafcff; }
        .main-content { margin-left: 270px; padding: 30px 40px 0 40px; min-height: 100vh; }
        h2 { text-align: center; margin-bottom: 26px; color: #2b303a; letter-spacing: 1px; }
        table { width: 95%; border-collapse: collapse; margin: 0 auto 18px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 14px rgba(0,0,0,0.08); }
        th, td { border: 1px solid #eaeaea; padding: 12px 12px; text-align: center; }
        th { background: #f0f4fb; color: #222; font-weight: 600; }
        tr:nth-child(even) { background: #f7fbfc; }
        tr:hover { background: #e7f7ff; }
        .table-actions { white-space: nowrap; min-width: 120px; }
        .btn { padding: 7px 16px; border-radius: 5px; font-size: 15px; text-decoration: none; color: #fff !important; display: inline-block; margin: 0 2px; font-weight: bold; border: none; transition: background 0.15s; }
        .btn.update { background: #298afc; }
        .btn.update:hover { background: #1765b8; }
        .btn.delete { background: #fb2555; }
        .btn.delete:hover { background: #ab092e; }
        .btn.add-btn { background-color: #29c772; color: #fff; margin-bottom: 0; margin-right: 8px; margin-top: 14px; }
        .btn.add-btn:hover { background-color: #178347; }
        .action-bar {
            margin: 15px 0 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 95%;
            margin-left: auto;
            margin-right: auto;
        }
        .search-input-container { position: relative; width: 400px; margin: 0; }
        #search_input { width: 100%; padding: 8px; border: 1px solid #999; border-radius: 4px; box-sizing: border-box; font-size: 16px; }
        #searchResultArea { position: absolute; width: 100%; top: 100%; z-index: 1000; background: #fff; border: 1px solid #999; border-top: none; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .export-select { padding: 6px 10px; border-radius: 4px; font-size: 15px; border: 1px solid #ccc; height: 34px; vertical-align: top; }
        .filename-input { padding: 6px 10px; border-radius: 4px; font-size: 15px; border: 1px solid #ccc; height: 32px; vertical-align: top; width: 150px; margin-right: 10px; display: none; }
        
        @media (max-width: 900px) { .main-content { margin-left: 0; padding: 12px; } table { width: 98%; } }
    </style>

    <script type="text/javascript">
        //SEARCH FUNCTIONS
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
                filenameInput.setAttribute('required', 'required'); 
            } else {
                filenameInput.style.display = 'none';
                filenameInput.removeAttribute('required');
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
                    onclick="return confirm('Exporting all transaction records now. Continue?');">
                Export Data
            </button>
        </form>
    </div>

    <?php if (!empty($searchTerm)): ?>
        <div style="margin-bottom: 15px; width: 95%; margin-left: auto; margin-right: auto; text-align: left;">
            <a href="index.php" class="btn delete-btn">Clear Search</a>
        </div>
    <?php endif; ?>

    <?php if (empty($data) && !empty($searchTerm)): ?>
        <div style="padding: 50px; text-align: center;">
            <h1>No Transaction Records Found for "<?= htmlspecialchars($searchTerm) ?>"</h1>
            <p>Please try a different search term or <a href="index.php">clear the search filter</a></p>
        </div>
    <?php else: ?>
        <table>
            <tr>
                <th>Medicine</th>
                <th>Student</th>
                <th>Quantity</th>
                <th>Date</th>
                <th class="table-actions">Action</th>
            </tr>
            <?php if(count($data)): ?>
                <?php foreach ($data as $row) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['medicineName']) ?></td>
                        <td><?= htmlspecialchars($row['studentName']) ?></td>
                        <td><?= htmlspecialchars($row['quantity']) ?></td>
                        <td><?= htmlspecialchars($row['transactionDate']) ?></td>
                        <td>
                            <a class="btn update" href="update.php?id=<?= $row['transactionID']; ?>">Update</a>
                            <a class="btn delete"
                               href="delete.php?id=<?= $row['transactionID']; ?>"
                               onclick="return confirm('Delete this record?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            <?php else: ?>
                <tr><td colspan="5" style="color:#b53d3d;font-weight:bold;">No Transaction Records Found.</td></tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>

    <a href="add.php" class="btn add-btn">➕ Add New Item</a>
</div>
</body>
</html>