<?php
include 'pdo.php';
$oop = new oop_class();
$idNum = $_GET['idNum'] ?? '';

if (trim($idNum) == '') exit;

$result = $oop->search_by_idNum($idNum);

if ($result) {
    ?>
    <div style="
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(44,140,222,0.09),0 0 0 1px #eaeaea;
        width: 66%;
        margin: 16px auto 22px auto;
        padding: 18px 20px 15px 20px;
        ">
        <h3 style="margin-top:0;margin-bottom:14px;font-size:1.2rem;color:#298afc;letter-spacing:1px;text-align:center;">
            Student Clinic Info
        </h3>
        <table style="width:100%;border-collapse:collapse;font-size:1rem;">
            <tr style="background:#f0f4fb;">
                <th style="padding:10px 10px;border:1px solid #eaeaea;">Name</th>
                <th style="padding:10px 10px;border:1px solid #eaeaea;">ID Number</th>
                <th style="padding:10px 10px;border:1px solid #eaeaea;">Department</th>
                <th style="padding:10px 10px;border:1px solid #eaeaea;">Complaint</th>
                <th style="padding:10px 10px;border:1px solid #eaeaea;">Visit Date</th>
            </tr>
            <tr>
                <td style="padding:8px 8px;border:1px solid #eaeaea;">
                    <?= htmlspecialchars($result['name']) ?>
                </td>
                <td style="padding:8px 8px;border:1px solid #eaeaea;">
                    <?= htmlspecialchars($result['idNum']) ?>
                </td>
                <td style="padding:8px 8px;border:1px solid #eaeaea;">
                    <?= htmlspecialchars($result['department']) ?>
                </td>
                <td style="padding:8px 8px;border:1px solid #eaeaea;">
                    <?= htmlspecialchars($result['complaint']) ?>
                </td>
                <td style="padding:8px 8px;border:1px solid #eaeaea;">
                    <?= htmlspecialchars($result['visitDate']) ?>
                </td>
            </tr>
        </table>
    </div>
    <?php
} else {
    echo "<div style='
        margin:18px auto 16px auto;
        padding:14px 0;
        font-size:1.1rem;
        color:#d11a49;
        background:#fff8f8;
        border-radius:8px;
        max-width:400px;
        text-align:center;
        box-shadow:0 1px 6px #f2b2b2;
        font-weight:bold;
    '>
        No student found for that ID number.
    </div>";
}
?>
