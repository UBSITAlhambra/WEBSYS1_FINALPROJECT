<?php
    include 'oop.php';
    $student = new oop_class();
    $activePage = 'visits';
    include '../sidebar/sidebar.php'; 

    $searchTerm = $_GET['search'] ?? '';
    $page_title = 'Student Clinic Records';

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
        body { margin: 0; font-family: Arial, sans-serif; background: #fafcff; }
        .main-content { margin-left: 270px; padding: 30px 40px 0 40px; min-height: 100vh; } /* Used 270px for Bootstrap alignment */
        h2 { margin-bottom: 26px; color: #2b303a; letter-spacing: 1px; text-align: center; }
        table { width: 97%; border-collapse: collapse; margin: 0 auto 18px auto; background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 14px rgba(0,0,0,0.08); }
        th, td { border: 1px solid #eaeaea; padding: 12px 12px; text-align: center; }
        th { background: #f0f4fb; color: #222; font-weight: 600; }
        tr:nth-child(even) { background: #f7fbfc; }
        tr:hover { background: #e7f7ff; }
        .table-actions { white-space: nowrap; min-width: 135px; }
        .btn { padding: 7px 16px; border-radius: 5px; font-size: 15px; text-decoration: none; color: #fff !important; display: inline-block; margin: 0 2px; font-weight: bold; border: none; transition: background 0.15s; }
        .btn.add-btn { background-color: #29c772; color: #fff; margin-bottom: 0; margin-right: 10px; margin-top: 14px; }
        .btn.add-btn:hover { background-color: #178347; }
        .btn.update-btn { background-color: #298afc; }
        .btn.update-btn:hover { background-color: #1765b8; }
        .btn.delete-btn { background-color: #fb2555; }
        .btn.delete-btn:hover { background-color: #ab092e; }
        .action-bar {
            margin: 15px 0 20px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 97%;
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

    <!-- STUDENT RECORDS TABLE -->
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
</body>
</html>
<?php
include 'oop.php';
$student = new oop_class();
$data = $student->show_data();
$activePage = 'visits';
include '../sidebar/sidebar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Student Clinic Records</title>
    <style>
       /* CSS Variables matching the Login/Register aesthetic */
:root {
    --primary-maroon: #800000;
    --light-bg: #f8f8f8;
    --box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); 
}
 
body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; /* Consistent Font */
    background: var(--light-bg);
}

.main-content {
    margin-left: 250px; /* MATCHES standard sidebar width */
    padding: 30px 40px 0 40px;
    background: var(--light-bg);
    min-height: 100vh;
}
h2 {
    margin-bottom: 26px;
    color: var(--primary-maroon); /* Maroon Heading */
    letter-spacing: 1px;
    text-align: center;
    font-weight: 600;
}
table {
    width: 97%;
    border-collapse: collapse;
    margin: 0 auto 18px auto;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--box-shadow); /* Consistent shadow */
}
th, td {
    border: 1px solid #eaeaea;
    padding: 12px 12px;
    text-align: center;
    font-size: 0.95rem;
}
th {
    background: var(--light-bg); /* Lighter header background */
    color: var(--primary-maroon); /* Maroon Header Text */
    font-weight: 700;
    border-bottom: 2px solid var(--primary-maroon); /* Stronger bottom border */
}
tr:nth-child(even) { background: #f7fbfc; }
tr:hover { background: #ffeaea; } /* Light Maroon Hover */
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
    background-color: var(--primary-maroon); /* Maroon for Add */
    color: #fff;
    margin-bottom: 0;
    margin-right: 10px;
    margin-top: 14px;
}
.btn.add-btn:hover { background-color: #a00000; } /* Darker Maroon */
.btn.update-btn {
    background-color: #2e6db4; /* Blue for Edit */
}
.btn.update-btn:hover {
    background-color: #1a4d8c;
}
.btn.delete-btn {
    background-color: #e74c3c; /* Red for Delete */
}
.btn.delete-btn:hover {
    background-color: #c0392b;
}
.table-actions {
    white-space: nowrap;
    min-width: 135px;
    text-align: center;
}
.top-buttons {
     text-align: right; 
     margin-bottom: 10px;
}

@media (max-width: 900px) {
    .main-content { margin-left: 0; padding: 12px; }
    table { width: 98%; }
}
    </style>
</head>
<body>
    <div class="main-content">
        <h2>Student Clinic Records</h2>
        <table>
            <tr>
                <th>Name</th>
                <th>LRN</th>
                <th>Grade & Section</th>
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
        <a href="add.php" class="btn add-btn"> Add New Student</a>
    </div>
</body>
</html>
