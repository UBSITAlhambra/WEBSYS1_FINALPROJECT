<?php
<<<<<<< Updated upstream
    include "oop.php"; 
    $oop = new oop_class();

    // --- 1. Get and Sanitize Input ---
    // Retrieve the search term from the URL parameter 'search_term' passed by the AJAX call.
    $searchTerm = $_GET['search_term'] ?? '';

    // Sanitize the search term using htmlspecialchars. This prevents potential XSS 
    $safeSearchTerm = htmlspecialchars($searchTerm);

    // --- 2. Execute Search Logic ---
    // Call the secure PDO search function to retrieve results.
    $results = $oop->search_inventory($safeSearchTerm);

?>
<style>
    .search-result-table tr:hover {
        background-color: #f0f0f0; /* Highlight the row when the mouse hovers over it */
        cursor: pointer; /* Change cursor to indicate a clickable row */
    }
</style>

<div style="max-height: 400px; overflow-y: auto;">
    <table class="search-result-table table table-hover table-striped table-sm" style="width: 100%; border-collapse: collapse;">
    
        <?php if (empty($results)): ?>
            <tr>
                <td colspan="7" style="text-align: center; padding: 15px;">
                    <h5 class="text-muted">No Inventory Records Found for "<?= $safeSearchTerm ?>"</h5>
                </td>
            </tr>
        <?php else: ?>
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Generic Name</th>
                    <th>Dosage</th>
                    <th>Brand</th>
                    <th>Category</th>
                    <th>Qty</th>
                    <th>Add Date</th>
                </tr>
            </thead>
            <tbody>
            
            <?php
                foreach ($results as $row): 
            ?>
                <tr onclick="getData('<?= htmlspecialchars($row['genericName'], ENT_QUOTES) ?>')">
                    <td><?= htmlspecialchars($row['itemID']) ?></td>
                    <td><?= htmlspecialchars($row['genericName']) ?></td>
                    <td><?= htmlspecialchars($row['dosage']) ?></td>
                    <td><?= htmlspecialchars($row['brand']) ?></td>
                    <td><?= htmlspecialchars($row['category']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td><?= htmlspecialchars($row['addDate']) ?></td>
                </tr>
            <?php endforeach; ?>
            
            </tbody>
=======
include "oop.php"; 
$oop = new oop_class();
$searchTerm = $_GET['search_term'] ?? '';
$safeSearchTerm = htmlspecialchars($searchTerm);
$results = $oop->search_inventory($safeSearchTerm);
?>
<style>
.search-result-table tr:hover { background-color: #e9e9e9; cursor: pointer; }
.search-result-table td { border: none; padding: 6px 8px; font-size: 12px; }
</style>

<div style="max-height: 300px; overflow-y: auto;">
    <table class="search-result-table" style="width: 100%; border-collapse: collapse;">
    
        <?php if (empty($results)): ?>
            <tr>
                <td colspan="4" style="text-align: center; padding: 15px;">
                    <h5 style="color:#6c757d; font-size:1rem; margin:0;">No Inventory Found for "<?= $safeSearchTerm ?>"</h5>
                </td>
            </tr>
        <?php else: ?>
            <tr style="background-color: #f2f2f2;">
                <td style="font-weight: bold;">Name</td>
                <td style="font-weight: bold;">Brand</td>
                <td style="font-weight: bold;">Qty</td>
                <td style="font-weight: bold;">Expiry</td>
            </tr>
            
            <?php foreach ($results as $row): ?>
                <tr onclick="getData('<?= htmlspecialchars($row['genericName'], ENT_QUOTES) ?>')">
                    <td><?= htmlspecialchars($row['genericName']) ?></td>
                    <td><?= htmlspecialchars($row['brand']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td><?= htmlspecialchars($row['expDate']) ?></td>
                </tr>
            <?php endforeach; ?>
>>>>>>> Stashed changes
        <?php endif; ?>
    </table>
</div>