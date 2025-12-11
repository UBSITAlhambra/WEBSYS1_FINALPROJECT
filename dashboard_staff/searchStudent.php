<?php
include 'pdo.php';
$oop = new oop_class();
$idNum = $_GET['idNum'] ?? '';

if (trim($idNum) == '') exit;

// Get the student record with full details including medicine info
$result = $oop->search_by_idNum($idNum);

if ($result) {
    // Get the student's recent visits with medicine details
    $studentVisits = $oop->get_student_recent_visits($idNum);
    ?>
    <div style="
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        width: 95%;
        margin: 20px auto;
        padding: 20px;
        overflow-x: auto;
        ">
        <h3 style="margin-top:0;margin-bottom:20px;font-size:1.3rem;color:#800000;letter-spacing:1px;text-align:center;">
            <i class="fas fa-user-injured"></i> Student Visit History
        </h3>
        
        <div style="margin-bottom: 20px; padding: 15px; background: #f8f9fa; border-radius: 8px; border-left: 4px solid #800000;">
            <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                <div>
                    <strong>Name:</strong> <?= htmlspecialchars($result['name']) ?>
                </div>
                <div>
                    <strong>Student ID:</strong> <?= htmlspecialchars($result['idNum']) ?>
                </div>
        </div>
        
        <?php if ($studentVisits && $studentVisits->rowCount() > 0): ?>
            <table style="width:100%;border-collapse:separate;border-spacing:0 8px;font-size:0.9rem;">
                <thead>
                    <tr style="background:#800000;color:white;font-weight:700;">
                        <th style="padding:12px 10px;text-align:left;border-radius:8px 0 0 0;">Name</th>
                        <th style="padding:12px 10px;text-align:left;">LRN</th>
                        <th style="padding:12px 10px;text-align:left;">Gender</th>
                        <th style="padding:12px 10px;text-align:left;">Grade & Section</th>
                        <th style="padding:12px 10px;text-align:left;">Complaint</th>
                        <th style="padding:12px 10px;text-align:left;">Medicine</th>
                        <th style="padding:12px 10px;text-align:left;">Quantity</th>
                        <th style="padding:12px 10px;text-align:left;">Remarks</th>
                        <th style="padding:12px 10px;text-align:left;border-radius:0 8px 0 0;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($visit = $studentVisits->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr style="background:#fff;box-shadow:0 2px 5px rgba(0,0,0,0.05);border-radius:8px;">
                        <td style="padding:10px;border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;">
                            <?= htmlspecialchars($visit['name']) ?>
                        </td>
                        <td style="padding:10px;border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;">
                            <?= htmlspecialchars($visit['idNum']) ?>
                        </td>
                        <td style="padding:10px;border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;">
                            <?= htmlspecialchars($visit['gender'] ?? 'N/A') ?>
                        </td>
                        <td style="padding:10px;border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;">
                            <?= htmlspecialchars($visit['department'] . ' - ' . ($visit['section'] ?? '')) ?>
                        </td>
                        <td style="padding:10px;border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;">
                            <?= htmlspecialchars($visit['complaint']) ?>
                        </td>
                        <td style="padding:10px;border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;">
                            <?= htmlspecialchars($visit['genericName'] ?? 'N/A') ?>
                        </td>
                        <td style="padding:10px;border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;">
                            <?= htmlspecialchars($visit['quantity'] ?? 'N/A') ?>
                        </td>
                        <td style="padding:10px;border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;">
                            <?= htmlspecialchars($visit['remarks'] ?? '') ?>
                        </td>
                        <td style="padding:10px;border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;">
                            <?= date('M j', strtotime($visit['visitDate'])) ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div style="text-align:center;padding:40px;color:#666;font-size:1.1rem;">
                <i class="fas fa-clipboard-list" style="font-size:2rem;color:#ccc;margin-bottom:15px;display:block;"></i>
                No recent visits found for this student.
            </div>
        <?php endif; ?>
    </div>
    <?php
} else {
    echo "<div style='
        margin:20px auto;
        padding:20px;
        font-size:1.1rem;
        color:#721c24;
        background:#f8d7da;
        border-radius:8px;
        width:95%;
        text-align:center;
        box-shadow:0 1px 6px rgba(0,0,0,0.1);
        font-weight:600;
        border-left:4px solid #f5c6cb;
    '>
        <i class=\"fas fa-user-times\" style=\"margin-right:10px;\"></i>
        No student found for ID number: " . htmlspecialchars($idNum) . "
    </div>";
}
?>

<!-- Add Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Add hover effect for table rows */
    tr:hover {
        background-color: #fff0f0 !important;
        transition: background-color 0.3s ease;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        table {
            font-size: 0.8rem;
        }
        th, td {
            padding: 8px 6px !important;
        }
        .container {
            padding: 15px !important;
        }
    }
</style>