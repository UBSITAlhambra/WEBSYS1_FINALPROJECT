<?php
include "oop.php";
$reports = new reports();
$topMeds = $reports->top_medicines();
$monthlyVisits = $reports->visits_per_month();
$topComplaints = $reports->top_complaints();
$topStudents = $reports->top_students();
?>
<?php $activePage = 'reports'; ?>
<?php include '../sidebar/sidebar.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Clinic Reports & Analytics</title>
    <style>
        .dashboard-btn {
            display: inline-block;
            background: #2d3a4c;
            color: #fff;
            padding: 12px 28px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            margin: 10px 40px 12px 40px;
            text-decoration: none;
        }
        .dashboard-btn:hover {
            background: #167bc8;
        }
        h2 {
            margin-top: 32px;
            color: #222;
            text-align: center;
            font-size: 1.3rem;
        }
        section {
            margin: 0 auto 34px auto;
            max-width: 640px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.09);
            border-radius: 10px;
            margin-bottom: 30px;
        }
        th, td {
            padding: 13px;
            border-bottom: 1px solid #ececec;
            text-align: center;
        }
        th {
            background: #3ac0f2;
            color: #fff;
        }
        tr:hover {
            background: #e6fcff;
        }
        td:last-child, th:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <h2>Most Dispensed Medicines</h2>
    <section>
        <table>
            <tr><th>Medicine</th><th>Total Dispensed</th></tr>
            <?php foreach($topMeds as $med): ?>
                <tr>
                    <td><?= htmlspecialchars($med['medicine']) ?></td>
                    <td><?= htmlspecialchars($med['total_dispensed']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <h2>Visits Per Month</h2>
    <section>
        <table>
            <tr><th>Month</th><th>Total Visits</th></tr>
            <?php foreach($monthlyVisits as $month): ?>
                <tr>
                    <td><?= htmlspecialchars($month['month']) ?></td>
                    <td><?= htmlspecialchars($month['total_visits']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <h2>Common Complaints</h2>
    <section>
        <table>
            <tr><th>Complaint</th><th>Frequency</th></tr>
            <?php foreach($topComplaints as $c): ?>
                <tr>
                    <td><?= htmlspecialchars($c['complaint']) ?></td>
                    <td><?= htmlspecialchars($c['count']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>

    <h2>Students with Most Visits</h2>
    <section>
        <table>
            <tr><th>Student Name</th><th>Visit Count</th></tr>
            <?php foreach($topStudents as $s): ?>
                <tr>
                    <td><?= htmlspecialchars($s['name']) ?></td>
                    <td><?= htmlspecialchars($s['visits']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </section>
</body>
</html>
