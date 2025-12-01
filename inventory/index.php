<?php
// Assume 'oop.php' and 'sidebar/sidebar.php' are correctly defined in the execution environment
include 'oop.php';
// The class is named 'oop_class' in the original code, and used to fetch inventory data here.
$inventory = new oop_class();
$data = $inventory->show_data();
$activePage = 'inventory';
include '../sidebar/sidebar.php';
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
        
        th:first-child, td:first-child { text-align: left; }
        th:last-child, td:last-child { text-align: center; }


        tr:nth-child(even) { background: #fefefe; } /* Lighter striping */
        tr:hover { background: #fff5f5; }

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
    </style>
</head>
<body>
    <div class="main-content">
        
        <div class="header-actions">
            <h1 class="title">Inventory List</h1>
            <input type="text" class="search-input" id="searchInput" placeholder="Search by Name, Dosage, or Category...">
        </div>
        
        <div class="table-container">
            <table>
                <tr>
                    <th style="text-align: left;">Generic Name</th>
                    <th>Dosage</th>
                    <th>Quantity</th>
                    <th>Category</th>
                    <th>Added Date</th>
                    <th>Expiry Date</th>
                    <th class="table-actions">Actions</th>
                </tr>
                <?php if (count($data) > 0): ?>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['genericName'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['dosage'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['quantity'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['category'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['addDate'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['expDate'] ?? 'N/A') ?></td>
                            <td class="btn-group">
                                <a href="update.php?id=<?= $row['itemID'] ?? '' ?>" class="btn update-btn" title="Edit Item">Update</a>
                                <a href="#" class="btn delete-btn"
                                   onclick="confirmDeletion(event, '<?= $row['itemID'] ?? '' ?>'); return false;"
                                   title="Delete Item">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="no-records">No inventory data found.</td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
        
        <div style="margin-top: 20px;">
            <a href="add.php" class="btn add-btn">Add New Item</a>
        </div>
    </div>

    <script>
        // --- Custom Deletion Confirmation Modal ---
        function confirmDeletion(event, recordId) {
            event.preventDefault(); 
            closeDeletionMessage(); // Cleanup existing

            // Simple overlay
            const overlay = document.createElement('div');
            overlay.id = 'overlay';
            overlay.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999; backdrop-filter: blur(2px);';
            document.body.appendChild(overlay);

            // Confirmation message box
            const confirmationMessage = document.createElement('div');
            confirmationMessage.className = 'deletion-message';
            confirmationMessage.style.cssText = `
                position: fixed; top: 50%; left: 50%; 
                transform: translate(-50%, -50%); 
                background: #fff; padding: 30px; 
                border-radius: 12px; 
                box-shadow: 0 8px 25px rgba(0,0,0,0.4); 
                z-index: 1000; text-align: center;
                max-width: 90%;
            `;
            confirmationMessage.innerHTML = `
                <p style="margin-bottom: 25px; font-weight: 700; color: var(--primary-maroon); font-size: 1.2rem;">Confirm Deletion</p>
                <p style="margin-bottom: 30px; font-size: 1rem; color: #333;">Are you sure you want to delete this inventory item? This action cannot be undone.</p>
                
                <div style="display: flex; justify-content: center; gap: 15px;">
                    <button onclick="performDeletion('${recordId}')" class="btn delete-btn" style="margin:0; width: 120px; padding: 10px 14px;">
                        Yes, Delete
                    </button>
                    <button onclick="closeDeletionMessage()" class="btn" style="background-color: #95a5a6; color: white; margin:0; width: 120px; padding: 10px 14px;">
                        Cancel
                    </button>
                </div>
            `;
            document.body.appendChild(confirmationMessage);
            
            // Define functions globally for inline HTML event handlers
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

        // --- Client-side Search/Filter Logic ---
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('keyup', filterTable);
            }
        });

        function filterTable() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const table = document.querySelector('table');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                // Skip header row (i=0) and the "no records" row if present
                if (tr[i].querySelector('.no-records')) continue; 
                
                let found = false;
                // Check Generic Name (Col 0), Dosage (Col 1), Category (Col 3)
                const checkColumns = [0, 1, 3]; 
                
                for (let j = 0; j < tr[i].cells.length; j++) {
                    if (checkColumns.includes(j)) {
                        const td = tr[i].getElementsByTagName('td')[j];
                        if (td) {
                            if (td.textContent.toUpperCase().indexOf(filter) > -1) {
                                found = true;
                                break;
                            }
                        }
                    }
                }
                tr[i].style.display = found ? "" : "none";
            }
        }
    </script>
</body>
</html>