<?php
include 'oop.php';
$inventory = new oop_class();

// Get the parameters from JavaScript
$search = $_GET['search'] ?? '';
$filter = $_GET['filter'] ?? 'all';

// Fetch data based on search term (or all data if empty)
if (!empty($search)) {
    // Assuming search_inventory returns an array of rows
    $data = $inventory->search_inventory($search);
} else {
    $data = $inventory->show_data();
}

// If no data found from database
if (empty($data)) {
    echo '<tr><td colspan="7" style="color:#b53d3d;font-weight:bold;padding:20px;">No records found.</td></tr>';
    exit;
}

// Loop through data and apply filters
$hasOutput = false;

foreach ($data as $row) {
    $quantity = (int)$row['quantity'];
    
    // Date Calculation
    $expiryDate = new DateTime($row['expDate']);
    $today = new DateTime();
    $interval = $today->diff($expiryDate);
    $daysUntilExpiry = (int)$interval->format('%r%a');

    // Determine Status
    $isLowStock = ($quantity <= 25);
    $isExpired = ($daysUntilExpiry <= 0);
    $isNearExpiry = ($daysUntilExpiry > 0 && $daysUntilExpiry <= 45);
    
    // FILTER LOGIC: Skip row if it doesn't match the selected filter
    if ($filter === 'low_stock' && !$isLowStock) continue;
    if ($filter === 'expired' && !$isExpired) continue;
    if ($filter === 'near_expiry' && !$isNearExpiry) continue;

    $hasOutput = true;
    
    // Determine CSS Class (Red Row)
    $rowClass = '';
    if ($isLowStock || $isExpired || $isNearExpiry) {
        $rowClass = 'alert-row';
    }
    ?>
    <tr class="<?= $rowClass ?>">
        <td><?= htmlspecialchars($row['genericName']) ?></td>
        <td><?= htmlspecialchars($row['dosage']) ?></td>
        <td>
            <?= htmlspecialchars($row['quantity']) ?>
            <?php if($isLowStock): ?>
                <br><span style="font-size:0.8em; font-weight:bold;">(Low Stock)</span>
            <?php endif; ?>
        </td>
        <td><?= htmlspecialchars($row['category']) ?></td>
        <td><?= htmlspecialchars($row['addDate']) ?></td>
        <td>
            <?= htmlspecialchars($row['expDate']) ?>
            <?php if($isExpired): ?>
                <br><span style="font-size:0.8em; font-weight:bold;">(Expired)</span>
            <?php elseif($isNearExpiry): ?>
                <br><span style="font-size:0.8em; font-weight:bold;">(Expiring Soon)</span>
            <?php endif; ?>
        </td>
        <td class="table-actions">
            <a href="update.php?id=<?= $row['itemID'] ?>" class="btn update-btn">Update</a>
            <a href="delete.php?id=<?= $row['itemID'] ?>" class="btn delete-btn"
               onclick="return confirm('Are you sure you want to delete this item?');">
                Delete
            </a>
        </td>
    </tr>
    <?php
}

if (!$hasOutput) {
    echo '<tr><td colspan="7" style="padding:20px;">No items match the selected filter.</td></tr>';
}
?>