<?php
    include 'oop.php';
    $inventory = new oop_class();

    $searchTerm = $_GET['search'] ?? '';
    $page_title = 'Inventory List';

    if (!empty($searchTerm)) {
        // If a query is present in the URL, fetch search results
        $data = $inventory->search_inventory($searchTerm); 
        $page_title = 'Search Results for: ' . htmlspecialchars($searchTerm);
    } else {
        // Otherwise, show all data
        $data = $inventory->show_data();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Inventory Management</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { border-collapse: collapse; width: 100%; margin: 15px 0; }
        th, td { border: 1px solid #999; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
<<<<<<< Updated upstream
=======
        .btn { padding: 6px 10px; text-decoration: none; border-radius: 4px; font-size: 14px; margin-right: 5px; }
        .add-btn { background-color: #4CAF50; color: white; margin-bottom: 10px; display: inline-block; }
        .update-btn { background-color: #2196F3; color: white; }
        .delete-btn { background-color: #f44336; color: white; }

        .search-input-container { 
            position: relative; 
            width: 500px; 
            margin: 15px 0; 
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
            font-size: 14px;
            border: 1px solid #ccc;
            height: 32px;
            vertical-align: top;
        }
        
        .filename-input {
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 14px;
            border: 1px solid #ccc;
            height: 32px;
            vertical-align: top;
            margin-right: 10px;
            display: none; 
        }
        
>>>>>>> Stashed changes
    </style>

    <script type="text/javascript">
        function showSearchRecord(term) {
            const query = term.trim(); 
            const resultsArea = document.getElementById("searchResultArea");

            if (query === "") {
                resultsArea.innerHTML = "";
                return;
            }

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
                if (query.trim() !== "") {
                    executeSearch(query);
                }
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            const formatSelect = document.getElementById('export-format-select');
            const filenameInput = document.getElementById('filename-input');
            
            function toggleFilenameVisibility() {
                const selectedFormat = formatSelect.value;
                if (selectedFormat === 'csv' || selectedFormat === 'sql') {
                    filenameInput.style.display = 'inline-block';
                    filenameInput.setAttribute('required', 'required'); 
                } else {
                    filenameInput.style.display = 'none';
                    filenameInput.removeAttribute('required');
                }
            }

            formatSelect.addEventListener('change', toggleFilenameVisibility);
            
            toggleFilenameVisibility();
        });
        
    </script>
</head>
<body>
<<<<<<< Updated upstream
<h2>Inventory List</h2>
<table>
    <tr>
        <th>ID</th>
        <th>Generic Name</th>
        <th>Dosage</th>
        <th>Brand</th>
        <th>Quantity</th>
        <th>Category</th>
        <th>Added Date</th>
        <th>Expiry Date</th>
    </tr>
    <?php foreach ($data as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['itemID']) ?></td>
            <td><?= htmlspecialchars($row['genericName']) ?></td>
            <td><?= htmlspecialchars($row['dosage']) ?></td>
            <td><?= htmlspecialchars($row['brand']) ?></td>
            <td><?= htmlspecialchars($row['quantity']) ?></td>
            <td><?= htmlspecialchars($row['category']) ?></td>
            <td><?= htmlspecialchars($row['addDate']) ?></td>
            <td><?= htmlspecialchars($row['expDate']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
=======

<h2 style="margin-top: 15px;"><?= $page_title ?></h2>

<hr>

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

<?php if (!empty($searchTerm)): ?>
    <div style="margin-bottom: 15px;">
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
            <th>ID</th>
            <th>Generic Name</th>
            <th>Dosage</th>
            <th>Brand</th>
            <th>Quantity</th>
            <th>Category</th>
            <th>Added Date</th>
            <th>Expiry Date</th>
            <th>Actions</th>
        </tr>

        <?php 
        foreach ($data as $row): 
        ?>
            <tr>
                <td><?= htmlspecialchars($row['itemID']) ?></td>
                <td><?= htmlspecialchars($row['genericName']) ?></td>
                <td><?= htmlspecialchars($row['dosage']) ?></td>
                <td><?= htmlspecialchars($row['brand']) ?></td>
                <td><?= htmlspecialchars($row['quantity']) ?></td>
                <td><?= htmlspecialchars($row['category']) ?></td>
                <td><?= htmlspecialchars($row['addDate']) ?></td>
                <td><?= htmlspecialchars($row['expDate']) ?></td>

                <td>
                    <a href="update.php?id=<?= $row['itemID'] ?>" class="btn update-btn">Update</a>
                    <a href="delete.php?id=<?= $row['itemID'] ?>" class="btn delete-btn"
                       onclick="return confirm('Are you sure you want to delete this item?');">
                        Delete
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<br>
<a href="add.php" class="btn add-btn">Add New Item</a>
<a href="#" class="btn add-btn">Home</a>
<br>
<form method="GET" action="export.php" style="display: inline-block; margin-left: 10px;">
    
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
>>>>>>> Stashed changes
</body>
</html>