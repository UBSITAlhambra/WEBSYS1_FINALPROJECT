<?php
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
        <?php endif; ?>
    </table>
</div>