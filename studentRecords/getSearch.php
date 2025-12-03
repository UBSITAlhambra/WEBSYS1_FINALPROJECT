<?php
    include "oop.php"; 
    $oop = new oop_class();

    $searchTerm = $_GET['search_term'] ?? '';
    $safeSearchTerm = htmlspecialchars($searchTerm);

    $results = $oop->search_studentRecords($safeSearchTerm);
?>
<style>
.search-result-table tr:hover { background-color: #e9e9e9; cursor: pointer; }
.search-result-table td { border: none; padding: 6px 8px; font-size: 12px; }
</style>

<div style="max-height: 300px; overflow-y: auto; position:relative; z-index:999;">
    <table class="search-result-table" style="width: 100%; border-collapse: collapse;">
    
        <?php if (empty($results)): ?>
            <tr>
                <td colspan="4" style="text-align: center; padding: 15px;">
                    <h5 style="color:#6c757d; font-size:1rem; margin:0;">No Records Found for "<?= $safeSearchTerm ?>"</h5>
                </td>
            </tr>
        <?php else: ?>
            <tr style="background-color: #f2f2f2;">
                <td style="font-weight: bold;">Name</td>
                <td style="font-weight: bold;">ID #</td>
                <td style="font-weight: bold;">Department</td>
                <td style="font-weight: bold;">Complaint</td>
            </tr>
            
            <?php foreach ($results as $row): ?>
                <tr onclick="getData('<?= htmlspecialchars($row['name'], ENT_QUOTES) ?>')">
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['idNum']) ?></td>
                    <td><?= htmlspecialchars($row['department']) ?></td>
                    <td><?= htmlspecialchars($row['complaint']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>