<?php
    include 'oop.php';
    $student = new oop_class();
<<<<<<< Updated upstream
=======
    $activePage = 'visits';
    include '../sidebar/sidebar.php';
>>>>>>> Stashed changes

    $searchTerm = $_GET['search'] ?? '';
    $page_title = 'Student Clinic Records';

    if (!empty($searchTerm)) {
<<<<<<< Updated upstream
        // If a query is present in the URL, fetch search results
        $data = $student->search_studentRecords($searchTerm); 
        $page_title = 'Search Results for: ' . htmlspecialchars($searchTerm);
    } else {
        // Otherwise, show all data
=======
        $data = $student->search_studentRecords($searchTerm); 
        $page_title = 'Search Results for: ' . htmlspecialchars($searchTerm);
    } else {
>>>>>>> Stashed changes
        $data = $student->show_data();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title><?= $page_title ?></title>
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
<<<<<<< Updated upstream
>>>>>>> Stashed changes
    </style>

=======
        .action-bar {
            margin: 15px 0 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 97%;
            margin-left: auto;
            margin-right: auto;
        }
        .search-input-container{
            position: relative;
            width: 400px;
            margin: 0;
        }
        #search_input
        { width: 100%;
            padding: 8px;
            border: 1px solid #999;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        #searchResultArea{
            position: absolute;
            width: 100%;
            top: 100%;
            z-index: 1000;
            background: #fff;
            border: 1px solid #999;
            border-top: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .export-select{
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 15px;
            border: 1px solid #ccc;
            height: 34px; vertical-align: top;
        }
        .filename-input{
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
    </style>
>>>>>>> Stashed changes
    <script type="text/javascript">
        function showSearchRecord(term) {
            const query = term.trim(); 
            const resultsArea = document.getElementById("searchResultArea");
<<<<<<< Updated upstream

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

=======
            if (query === "") {resultsArea.innerHTML = ""; return;}
            const url = "getSearch.php?search_term=" + encodeURIComponent(query);
            fetch(url).then(response => response.text()).then(data => resultsArea.innerHTML = data).catch(error => console.error("Fetch Error:", error));
        }
        function executeSearch(query) {
            window.location.href = "index.php?search=" + encodeURIComponent(query.trim());
        }
>>>>>>> Stashed changes
        function getData(name) {
            document.getElementById("search_input").value = name;
            document.getElementById("searchResultArea").innerHTML = ""; 
            executeSearch(name); 
        }
<<<<<<< Updated upstream

=======
>>>>>>> Stashed changes
        function handleSearchKeyPress(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); 
                const query = document.getElementById("search_input").value;
<<<<<<< Updated upstream
                if (query.trim() !== "") {
                    executeSearch(query);
                }
            }
        }
    </script>
</head>
<body>

<h2 style="margin-top: 15px;"><?= $page_title ?></h2>

<hr>

<div class="search-input-container">
    <input type="text" 
           id="search_input" 
           name="search"
           placeholder="Search by Name, ID, or Complaint..." 
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
        <h1>No Student Records Found for "<?= htmlspecialchars($searchTerm) ?>"</h1>
        <p>Please try a different search term or <a href="index.php">Clear the search filter</a>.</p>
    </div>
<?php else: ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>ID Number</th>
            <th>Department</th>
            <th>Complaint</th>
            <th>Visit Date</th>
            <th>Actions</th>
        </tr>

<<<<<<< Updated upstream
</table>
=======
        <?php 
            foreach ($data as $row): 
        ?>
            <tr>
                <td><?= htmlspecialchars($row['ID']) ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['idNum']) ?></td>
                <td><?= htmlspecialchars($row['department']) ?></td>
                <td><?= htmlspecialchars($row['complaint']) ?></td>
                <td><?= htmlspecialchars($row['visitDate']) ?></td>
                <td>
                    <a href="update.php?id=<?= $row['ID'] ?>" class="btn update-btn">Edit</a>
                    <a href="delete.php?id=<?= $row['ID'] ?>" class="btn delete-btn" 
                       onclick="return confirm('Delete this record?');">
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
>>>>>>> Stashed changes

=======
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

    <h2 style="margin-top: 15px;"><?= $page_title ?></h2>

    <div class="action-bar">
        <div class="search-input-container">
            <input type="text" 
                   id="search_input" 
                   name="search"
                   placeholder="Search by Name, ID, Department, or Complaint..." 
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
                    onclick="return confirm('Exporting all student records now. Continue?');">
                Export Data
            </button>
        </form>
    </div>
    
    <?php if (!empty($searchTerm)): ?>
        <div style="margin-bottom: 15px; width: 97%; margin-left: auto; margin-right: auto; text-align: left;">
            <a href="index.php" class="btn delete-btn">Clear Search</a>
        </div>
    <?php endif; ?>

    <?php if (empty($data) && !empty($searchTerm)): ?>
        <div style="padding: 50px; text-align: center;">
            <h1>No Records Found for "<?= htmlspecialchars($searchTerm) ?>"</h1>
            <p>Please try a different search term or <a href="index.php">clear the search filter</a></p>
        </div>
    <?php else: ?>
        <table>
            <tr>
                <th>Name</th>
                <th>ID Number</th>
                <th>Department</th>
                <th>Complaint</th>
                <th>Visit Date</th>
                <th class="table-actions">Actions</th>
            </tr>
            <?php if(count($data)): ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['idNum']) ?></td>
                        <td><?= htmlspecialchars($row['department']) ?></td>
                        <td><?= htmlspecialchars($row['complaint']) ?></td>
                        <td><?= htmlspecialchars($row['visitDate']) ?></td>
                        <td>
                            <a href="update.php?id=<?= $row['ID'] ?>" class="btn update-btn">Edit</a>
                            <a href="delete.php?id=<?= $row['ID'] ?>" class="btn delete-btn"
                               onclick="return confirm('Delete this record?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="color:#b53d3d;font-weight:bold;">No Student Clinic Records Found.</td>
                </tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>
    <a href="add.php" class="btn add-btn">➕ Add New Item</a>
    <a href="../transaction/" class="btn add-btn" style="background:#2977f6;">View Transaction</a>
</div>
>>>>>>> Stashed changes
</body>
</html>