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
            --header-bg: #fff;
            --secondary-text: #555;
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
            min-width: 1100px; /* Increased min-width to accommodate new column */
        }

        th, td {
            border: 1px solid #e0e0e0;
            padding: 14px 15px;
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
            text-align: center;
        }
        
        th:first-child, td:first-child { text-align: left; }
        th:last-child, td:last-child { text-align: center; }


        tr:nth-child(even) { background: #fefefe; }
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
        
        .btn-group .btn {
            margin: 0 2px;
            padding: 6px 10px;
            font-size: 12px;
            border-radius: 5px;
            font-weight: 500;
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
            white-space: nowrap;
            min-width: 135px;
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
        }
    </style>
</head>
<body>
    <div class="main-content">
        
        <div class="header-actions">
            <h1 class="title">Student Clinic Records</h1>
            <input type="text" class="search-input" id="searchInput" placeholder="Search by Name, LRN, or Complaint...">
        </div>
        
        <div class="table-container">
            <table>
                <tr>
                    <th style="text-align: left;">Name</th>
                    <th>Gender</th>
                    <th>Status/Role</th> <th>LRN</th>
                    <th>Grade & Section</th>
                    <th>Complaint</th>
                    <th>Temp.</th>
                    <th>BP</th>
                    <th>Pulse</th>
                    <th>Resp. Rate</th>
                    <th>Visit Date</th>
                    <th class="table-actions">Actions</th>
                </tr>

                <?php if (is_array($data) && count($data)): ?>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['name'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['gender'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['role'] ?? 'N/A') ?></td> <td><?= htmlspecialchars($row['idNum'] ?? 'N/A') ?></td>

                            <td>
                                <?= htmlspecialchars($row['department'] ?? '') ?> 
                                - 
                                <?= htmlspecialchars($row['section'] ?? '') ?>
                            </td>

                            <td><?= htmlspecialchars($row['complaint'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['temperature'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['bloodPressure'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['pulse'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['respiratoryRate'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($row['visitDate'] ?? 'N/A') ?></td>

                            <td class="btn-group">
                                <a href="update.php?id=<?= $row['ID'] ?? '' ?>" class="btn update-btn" title="Edit Record">Edit</a>
                                <a href="delete.php?id=<?= $row['ID'] ?? '' ?>" class="btn delete-btn" 
                                   onclick="return confirmDeletion(event, '<?= $row['ID'] ?? '' ?>');"
                                   title="Delete Record">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                <?php else: ?>
                    <tr>
                        <td colspan="12" class="no-records">
                            No Clinic Records Found.
                        </td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
        
        <div style="margin-top: 20px;">
            <a href="add.php" class="btn add-btn"> Add New Record</a>
        </div>
    </div>
    
    <script>
        // Custom deletion confirmation (kept the original functionality)
        function confirmDeletion(event, recordId) {
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
        
        // Simple client-side search/filter logic
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
                if (tr[i].querySelector('.no-records')) continue; 
                
                let found = false;
                // CHECK Name (Col 0), LRN (Col 3), Complaint (Col 5)
                const checkColumns = [0, 3, 5]; 
                
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