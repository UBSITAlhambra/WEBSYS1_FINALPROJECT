<?php
// 1. INCLUDE THE GUARD FIRST (Handles session, security check, and browser cache disabling)
include '../login/auth_guard.php'; 

include "oop.php";
$oop = new oop_class();
$activePage = 'transactions';

// Sidebar inclusion
include '../sidebar/sidebar.php'; 

$searchTerm = $_GET['search'] ?? '';
$page_title = 'Treatment Records';

// 2. FETCH DATA ONLY AFTER AUTH IS CONFIRMED
$data = !empty($searchTerm) ? $oop->search_transactions_by_name($searchTerm) : $oop->show_data();
$page_title = !empty($searchTerm) ? 'Search Results for: ' . htmlspecialchars($searchTerm) : 'Treatment Records';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $page_title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
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
        
        /* SCROLLABLE TABLE CONTAINER */
        .table-container {
            width: 95%;
            margin: 0 auto 18px auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: var(--box-shadow);
            max-height: 680px; /* Fixed height for scrolling */
            overflow-y: auto; /* Vertical scroll */
            position: relative;
        }

        /* Make header sticky */
        .table-container table thead {
            position: sticky;
            top: 0;
            z-index: 10;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        
        th, td {
            border: 1px solid #eaeaea;
            padding: 12px 12px;
            text-align: left;
            font-size: 0.95rem;
        }
        
        th {
            background: var(--primary-maroon);
            color: white;
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
            margin: 15px auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 95%;
            flex-wrap: wrap;
            gap: 15px;
        }

        .search-input-container {
            position: relative;
            flex: 1;
            min-width: 300px;
            max-width: 400px;
        }
        #search_input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 0.95rem;
        }
        #search_input:focus {
            outline: none;
            border-color: var(--primary-maroon);
            box-shadow: 0 0 6px rgba(128,0,0,0.3);
        }

        .action-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .export-select {
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 0.9rem;
            border: 1px solid #ccc;
            height: 34px;
            vertical-align: top;
        }

        .filename-input {
            padding: 6px 10px;
            border-radius: 8px;
            font-size: 0.9rem;
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

        /* Filter info */
        .filter-info {
            width: 95%;
            margin: 10px auto;
            padding: 10px 15px;
            background-color: #e8f4fc;
            border-left: 4px solid #2e6db4;
            border-radius: 4px;
            color: #2e6db4;
            font-size: 0.95rem;
        }

        /* Loading indicator */
        .loading {
            text-align: center;
            padding: 20px;
            color: #666;
            font-style: italic;
        }

        /* Clear search button */
        .clear-search {
            text-decoration: none;
            color: #e74c3c;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 5px;
            border: 1px solid #e74c3c;
            transition: all 0.2s;
        }
        .clear-search:hover {
            background-color: #e74c3c;
            color: white;
        }

        /* Actions below search */
        .actions-below {
            width: 95%;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Row count */
        .row-count {
            position: absolute;
            top: 10px;
            right: 20px;
            background: var(--primary-maroon);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            z-index: 5;
        }
        
        @media (max-width: 900px) {
            .main-content {
                margin-left: 0;
                padding: 12px;
            }
            .table-container {
                width: 98%;
                max-height: 500px;
            }
            .action-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            .search-input-container {
                min-width: 100%;
                max-width: 100%;
            }
            .actions-below {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
<div class="main-content">
    <h2><?= $page_title ?></h2>

    <!-- Action Bar with Search -->
    <div class="action-bar">
        <div class="search-input-container">
            <input type="text" 
                   id="search_input" 
                   name="search"
                   placeholder="Search by Medicine, Student, or ID..." 
                   value="<?= htmlspecialchars($searchTerm) ?>"
                   autocomplete="off">
        </div>
        
        <div class="action-right">
            <form method="GET" action="export.php" id="export-form">
                <input type="hidden" name="search" id="export-search" value="<?= htmlspecialchars($searchTerm) ?>">
                <input type="text" 
                       name="filename" 
                       id="filename-input"
                       class="filename-input" 
                       placeholder="Filename (Optional)"> 
                <select name="format" id="export-format-select" class="export-select">
                    <option value="csv">CSV (Spreadsheet)</option>
                    <option value="json">JSON (Data)</option>
                    <option value="sql">SQL (Database)</option>
                </select>
                <button type="submit" class="btn update" 
                        style="background-color: #555;">
                    Export
                </button>
            </form>
        </div>
    </div>

    <!-- Show search info if search is applied -->
    <?php if (!empty($searchTerm)): ?>
        <div class="actions-below">
            <div class="filter-info">
                <i class="fas fa-search"></i> Showing search results for: "<?= htmlspecialchars($searchTerm) ?>"
            </div>
            
            <a href="index.php" class="clear-search">
                <i class="fas fa-times"></i> Clear Search
            </a>
        </div>
    <?php endif; ?>

    <!-- Scrollable Table Container -->
    <div class="table-container">
        <div class="row-count" id="row-count">
            <?= count($data) ?> record<?= count($data) != 1 ? 's' : '' ?>
        </div>
        <table id="treatment-table">
            <thead>
                <tr>
                    <th>Medicine</th>
                    <th>Student</th>
                    <th>Quantity</th>
                    <th>Date</th>
                    <th>Remarks</th>
                    <th class="table-actions">Action</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['medicineName'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['studentName'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['quantity'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['transactionDate'] ?? '') ?></td>
                            <td><?= htmlspecialchars($row['remarks'] ?? '') ?></td>
                            <td class="table-actions">
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
                    <tr>
                        <td colspan="6" style="color:#b53d3d;font-weight:bold;text-align:center;padding:40px;">
                            No Treatment Records Found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <a href="add.php" class="btn add-btn">Add New Treatment</a>
</div>

<script>
// Debounce function to limit API calls
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Function to update the table with live data
function updateTable() {
    const searchTerm = $('#search_input').val().trim();
    
    // Show loading state
    $('#table-body').html(`
        <tr>
            <td colspan="6" class="loading">
                <i class="fas fa-spinner fa-spin"></i> Loading...
            </td>
        </tr>
    `);
    
    // Make AJAX request
    $.ajax({
        url: 'live_search.php',
        method: 'GET',
        data: {
            search: searchTerm
        },
        success: function(response) {
            $('#table-body').html(response);
            
            // Update row count
            const rowCount = $('#table-body tr').filter(function() {
                return $(this).find('td').length > 0;
            }).length;
            $('#row-count').text(rowCount + ' record' + (rowCount !== 1 ? 's' : ''));
            
            // Update URL without reloading page
            updateURL(searchTerm);
            
            // Update export form hidden field
            $('#export-search').val(searchTerm);
        },
        error: function() {
            $('#table-body').html(`
                <tr>
                    <td colspan="6" style="color:#e74c3c;text-align:center;padding:40px;">
                        Error loading data. Please try again.
                    </td>
                </tr>
            `);
            $('#row-count').text('0 records');
        }
    });
}

// Function to update URL (for bookmarking/share)
function updateURL(searchTerm) {
    let url = 'index.php?';
    
    if (searchTerm) {
        url += 'search=' + encodeURIComponent(searchTerm);
    } else {
        url = 'index.php';
    }
    
    // Update browser history without reloading
    window.history.replaceState({}, document.title, url);
}

// Initialize on page load
$(document).ready(function() {
    // Set up event listeners with debounce
    const debouncedUpdate = debounce(updateTable, 300);
    
    $('#search_input').on('input', debouncedUpdate);
    
    // Search on Enter key
    $('#search_input').on('keydown', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            updateTable();
        }
    });
    
    // Export filename visibility
    function toggleFilenameVisibility() {
        const filenameInput = $('#filename-input');
        const selectedFormat = $('#export-format-select').val();
        if (selectedFormat === 'csv' || selectedFormat === 'sql') {
            filenameInput.show();
        } else {
            filenameInput.hide();
        }
    }
    
    $('#export-format-select').on('change', toggleFilenameVisibility);
    toggleFilenameVisibility();
    
    // Export form handler
    $('#export-form').on('submit', function(e) {
        e.preventDefault();
        if (confirm('Exporting treatment records. Continue?')) {
            // Get current search value
            const searchTerm = $('#search_input').val().trim();
            
            // Update hidden field
            $('#export-search').val(searchTerm);
            
            // Submit form
            this.submit();
        }
    });
    
    // Focus search input on page load
    $('#search_input').focus();
});

// Prevent page cache issues
window.addEventListener('pageshow', function (event) {
    if (event.persisted) {
        window.location.reload();
    }
});
</script>

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</body>
</html>