<?php
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
        <?php endif; ?>
    </table>
</div>