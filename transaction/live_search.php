<?php
session_start();
include "oop.php";
$oop = new oop_class();

$searchTerm = $_GET['search'] ?? '';

// Get filtered data
$data = !empty($searchTerm) ? $oop->search_transactions_by_name($searchTerm) : $oop->show_data();

// Generate HTML for table rows
if (!empty($data)) {
    foreach ($data as $row): ?>
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
    <?php endforeach;
} else {
    echo '<tr><td colspan="6" style="color:#b53d3d;font-weight:bold;text-align:center;padding:40px;">No Treatment Records Found.</td></tr>';
}
?>