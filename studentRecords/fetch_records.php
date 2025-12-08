<?php
include 'oop.php';
$student = new oop_class();

// 1. Get Parameters from JavaScript
$search = $_GET['search'] ?? '';
$roleFilter = $_GET['role'] ?? 'all';
$deptFilter = $_GET['dept'] ?? 'all';
$complaintFilter = $_GET['complaint'] ?? 'all';

// 2. Fetch Data
// If there is a search term, use the search function. Otherwise get all data.
if (!empty($search)) {
    $data = $student->search_studentRecords($search);
} else {
    $data = $student->show_data();
}

// 3. Output Data
if (empty($data)) {
    echo '<tr><td colspan="12" style="color:#b53d3d;font-weight:bold;padding:20px;">No records found.</td></tr>';
    exit;
}

$hasOutput = false;

foreach ($data as $row) {
    // --- FILTER LOGIC ---
    // Skip this row if it doesn't match the selected filters
    
    // Role Filter (Exact match)
    if ($roleFilter !== 'all' && stripos($row['role'], $roleFilter) === false) {
        continue;
    }

    // Department/Grade Filter (Partial match, e.g., "Grade 11" matches "Grade")
    if ($deptFilter !== 'all' && stripos($row['department'], $deptFilter) === false) {
        continue;
    }

    // Complaint Filter (Partial match)
    if ($complaintFilter !== 'all' && stripos($row['complaint'], $complaintFilter) === false) {
        continue;
    }

    $hasOutput = true;
    ?>
    <tr>
        <td><?= htmlspecialchars($row['name'] ?? 'N/A') ?></td>
        <td><?= htmlspecialchars($row['gender'] ?? 'N/A') ?></td>
        <td><?= htmlspecialchars($row['idNum'] ?? 'N/A') ?></td>
        <td><?= htmlspecialchars($row['department'] ?? 'N/A') ?></td> 
        <td><?= htmlspecialchars($row['role'] ?? 'N/A') ?></td> 
        <td><?= htmlspecialchars($row['complaint'] ?? 'N/A') ?></td>
        <td><?= htmlspecialchars($row['temperature'] ?? 'N/A') ?></td>
        <td><?= htmlspecialchars($row['bloodPressure'] ?? 'N/A') ?></td>
        <td><?= htmlspecialchars($row['pulse'] ?? 'N/A') ?></td>
        <td><?= htmlspecialchars($row['respiratoryRate'] ?? 'N/A') ?></td>
        <td><?= htmlspecialchars($row['visitDate'] ?? 'N/A') ?></td>
        <td class="table-actions">
            <a href="update.php?id=<?= $row['ID'] ?? '' ?>" class="btn update-btn">Edit</a>
            <a href="delete.php?id=<?= $row['ID'] ?? '' ?>" class="btn delete-btn"
               onclick="return confirmDeletion(event, '<?= $row['ID'] ?? '' ?>');">Delete</a>
        </td>
    </tr>
    <?php
}

if (!$hasOutput) {
    echo '<tr><td colspan="12" style="padding:20px; text-align:center;">No records match the selected filters.</td></tr>';
}
?>