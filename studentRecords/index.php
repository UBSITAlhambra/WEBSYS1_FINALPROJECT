<?php
// PHP LOGIC RESOLUTION: Combining all necessary includes and search logic.
session_start();
include 'oop.php';
$student = new oop_class();
$activePage = 'visits';
include '../sidebar/sidebar.php'; 
    if(!isset($_SESSION['user_id'])){
        header('Location: ../login/');
    }
$searchTerm = $_GET['search'] ?? '';
$page_title = 'BCNHS Clinic Records';

if (!empty($searchTerm)) {
    $data = $student->search_studentRecords($searchTerm); 
    $page_title = 'Search Results for: ' . htmlspecialchars($searchTerm);
} else {
    $data = $student->show_data();
}
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
}

h2 {
    margin-bottom: 26px;
    color: var(--primary-maroon);
    letter-spacing: 1px;
    text-align: center;
    font-weight: 600;
}

/* ACTION BAR: search left, export right */
.action-bar {
    margin: 15px auto 20px auto;
    width: 97%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

/* SEARCH */
.search-input-container {
    position: relative;
    width: 380px;
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

/* EXPORT */
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

/* TABLE */
table {
    width: 97%;
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
    text-align: center;
    font-size: 0.95rem;
}
th {
    background: var(--light-bg);
    color: var(--primary-maroon);
    font-weight: 700;
    border-bottom: 2px solid var(--primary-maroon);
}
tr:nth-child(even) { background: #f7fbfc; }
tr:hover { background: #ffeaea; }

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
}
.btn.add-btn {
    background-color: var(--primary-maroon);
    color: #fff;
    margin-bottom: 0;
    margin-right: 10px;
    margin-top: 14px;
}
.btn.add-btn:hover { background-color: #a00000; }
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
    white-space: nowrap;
    min-width: 135px;
    text-align: center;
}

@media (max-width: 900px) {
    .main-content { margin-left: 0; padding: 12px; }
    table { width: 98%; }
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
                <button onclick="performDeletion('${recordId}')" style="background-color: #e74c3c; color: white; border: none; padding: 10px 20px; border-radius: 5px; margin-right: 10px; cursor: pointer; transition: background 0.2s;">Yes, Delete</button>
                <button onclick="closeDeletionMessage()" style="background-color: #95a5a6; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; transition: background 0.2s;">Cancel</button>
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
            <button type="submit" class="btn update-btn" 
                    style="background-color: #555;" 
                    onclick="return confirm('Exporting all student records now. Continue?');">
                Export Data
            </button>
        </form>
    </div>

    <?php if (!empty($searchTerm)): ?>
        <div style="margin-bottom: 15px; width: 97%; margin-left: auto; margin-right: auto; text-align: left;">
            <a href="index.php" class="btn delete-btn" style="color: #fff; text-decoration: none;">Clear Search</a>
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
            <?php if(count($data)): ?>
                <?php foreach ($data as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['gender'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['idNum'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['department'] ?? 'N/A') ?></td> 
                        <td><?= htmlspecialchars($row['role'] ?? 'N/A') ?></td> 
                        <td><?= htmlspecialchars($row['complaint'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['temperature'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['bloodPressure'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['pulse'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['respiratoryRate'] ?? 'N/A') ?></td>
                        <td><?= htmlspecialchars($row['visitDate'] ?? 'N/A') ?></td>
                        <td>
                            <a href="update.php?id=<?= $row['ID'] ?? '' ?>" class="btn update-btn">Edit</a>
                            <a href="delete.php?id=<?= $row['ID'] ?? '' ?>" class="btn delete-btn"
                               onclick="return confirmDeletion(event, '<?= $row['ID'] ?? '' ?>');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="11" style="color:#b53d3d;font-weight:bold;">No Clinic Records Found.</td>
                </tr>
            <?php endif; ?>
        </table>
    <?php endif; ?>
    
    <a href="add.php" class="btn add-btn">Add New Person</a>
</div>
</body>
</html>
