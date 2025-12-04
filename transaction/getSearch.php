<?php
    include "oop.php"; 
    $oop = new oop_class();

    $searchTerm = $_GET['search_term'] ?? '';
    $safeSearchTerm = htmlspecialchars($searchTerm);

    $results = $oop->search_transactions_by_name($safeSearchTerm);
?>
<style>
    .search-result-table tr:hover {
        background-color: #e9e9e9; 
        cursor: pointer;
    }
    .search-result-table td {
        border: none;
        padding: 6px 8px;
        font-size: 12px;
    }
</style>

<div style="max-height: 300px; overflow-y: auto;">
    <table class="search-result-table" style="width: 100%; border-collapse: collapse;">
    
        <?php if (empty($results)): ?>
            <tr>
                <td colspan="4" style="text-align: center; padding: 15px;">
                    <h5 class="text-muted">No Transactions Found for "<?= $safeSearchTerm ?>"</h5>
                </td>
            </tr>
        <?php else: ?>
            <tr style="background-color: #f2f2f2;">
                <td style="font-weight: bold;">Medicine</td>
                <td style="font-weight: bold;">Student</td>
                <td style="font-weight: bold;">Qty</td>
                <td style="font-weight: bold;">Date</td>
            </tr>
            
            <?php foreach ($results as $row): ?>
                <?php
                    $searchQuery = htmlspecialchars($row['medicineName'], ENT_QUOTES);
                ?>
                <tr onclick="getData('<?= $searchQuery ?>')">
                    <td><?= htmlspecialchars($row['medicineName']) ?></td>
                    <td><?= htmlspecialchars($row['studentName']) ?></td>
                    <td><?= htmlspecialchars($row['quantity']) ?></td>
                    <td><?= htmlspecialchars($row['transactionDate']) ?></td>
                </tr>
            <?php endforeach; ?>

        <?php endif; ?>
    </table>
</div>