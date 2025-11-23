<?php
    include "oop.php";
    $oop = new oop_class();

    $searchTerm = $_GET['search'] ?? '';
    $page_title = 'Transaction Records';

    if (!empty($searchTerm)) {
        // If a query is present in the URL, fetch search results using the joined search function
        $data = $oop->search_transactions_by_name($searchTerm); 
        $page_title = 'Search Results for: ' . htmlspecialchars($searchTerm);
    } else {
        // Otherwise, show all data using the existing JOIN query
        $data = $oop->show_data();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title><?= $page_title ?></title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 90%; border-collapse: collapse; margin: 20px auto; }
        table, th, td { border: 1px solid black; padding: 10px; }
        th { background: #f3f3f3; }
        .btn { padding: 6px 10px; text-decoration: none; border-radius: 4px; font-size: 14px; margin-right: 5px; }
        .add-btn { background-color: #4CAF50; color: white; margin-bottom: 10px; display: inline-block; }
        .update-btn { background-color: #007bff; color: white; }
        .delete-btn { background-color: red; }
        
        .search-input-container { 
            position: relative; 
            width: 500px; 
            margin: 15px auto;
        }
        #search_input {
            width: 100%;
            padding: 8px;
            border: 1px solid #999;
            border-radius: 4px;
            box-sizing: border-box; 
            font-size: 16px;
        }
<<<<<<< Updated upstream
        a.btn.delete {
            background: red;
=======
        #searchResultArea {
            position: absolute; 
            width: 100%; 
            top: 100%; 
            z-index: 1000; 
            background: #fff; 
            border: 1px solid #999;
            border-top: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
>>>>>>> Stashed changes
        }
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
    </script>
</head>
<body>

<h2 style="text-align:center; margin-top: 15px;"><?= $page_title ?></h2>

<<<<<<< Updated upstream
<table>
    <tr>
        <th>ID</th>
        <th>Medicine</th>
        <th>Student</th>
        <th>Quantity</th>
        <th>Date</th>
        <th>Action</th>
    </tr>
=======
<div class="search-input-container">
    <input type="text" 
           id="search_input" 
           name="search"
           placeholder="Search by Medicine Name, Student Name, or Transaction ID..." 
           value="<?= htmlspecialchars($searchTerm) ?>"
           oninput="showSearchRecord(this.value);" 
           onkeydown="handleSearchKeyPress(event);"
           autocomplete="off">
>>>>>>> Stashed changes

    <div id="searchResultArea"></div>
</div>
<?php if (!empty($searchTerm)): ?>
    <div style="text-align: center; margin-bottom: 15px;">
        <a href="index.php" class="btn delete-btn">Clear Search</a>
    </div>
<?php endif; ?>

<?php if (empty($data) && !empty($searchTerm)): ?>
    <div style="padding: 50px; text-align: center;">
        <h1>No Transaction Records Found for "<?= htmlspecialchars($searchTerm) ?>"</h1>
        <p>Please try a different search term or <a href="index.php">clear the search filter</a>.</p>
    </div>
<?php else: ?>
    <table>
        <tr>
<<<<<<< Updated upstream
            <td><?= $row['transactionID']; ?></td>
            <td><?= $row['medicineName']; ?></td>
            <td><?= $row['studentName']; ?></td>
            <td><?= $row['quantity']; ?></td>
            <td><?= $row['transactionDate']; ?></td>

            <td>
                <a class="btn" href="update.php?id=<?= $row['transactionID']; ?>">Update</a>
                <a class="btn delete" 
                   href="delete.php?id=<?= $row['transactionID']; ?>" 
                   onclick="return confirm('Delete this record?');">
                   Delete
                </a>
            </td>
=======
            <th>Medicine</th>
            <th>Student</th>
            <th>Quantity</th>
            <th>Date</th>
            <th>Action</th>
>>>>>>> Stashed changes
        </tr>

<<<<<<< Updated upstream
</table>
=======
        <?php foreach ($data as $row) { ?>
            <tr>
                <td><?= htmlspecialchars($row['medicineName']); ?></td>
                <td><?= htmlspecialchars($row['studentName']); ?></td>
                <td><?= htmlspecialchars($row['quantity']); ?></td>
                <td><?= htmlspecialchars($row['transactionDate']); ?></td>

                <td>
                    <a class="btn" href="update.php?id=<?= $row['transactionID']; ?>">Update</a>
                    <a class="btn delete" 
                       href="delete.php?id=<?= $row['transactionID']; ?>" 
                       onclick="return confirm('Delete this record?');">
                        Delete
                    </a>
                </td>
            </tr>
        <?php } ?>
    </table>
<?php endif; ?>

<br>
<a href="add.php" class="btn add-btn">Add New Item</a>
<a href="#" class="btn add-btn">Home</a>
>>>>>>> Stashed changes

</body>
</html>