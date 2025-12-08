<?php
// 1. INCLUDE THE GUARD FIRST (Handles session, auth check, and No-Cache headers)
include '../login/auth_guard.php'; 

include "oop.php";
$reports = new reports();

// 2. FETCH ANALYTICS ONLY AFTER AUTH IS CONFIRMED
$topMeds = $reports->top_medicines();
$monthlyVisits = $reports->visits_per_month();
$topComplaints = $reports->top_complaints();
$topStudents = $reports->top_students();
$summary = $reports->get_summary_by_department();

$filterGrade = isset($_GET['grade']) ? $_GET['grade'] : "";

$activePage = 'reports'; 
include '../sidebar/sidebar.php'; 
?>
<?php $activePage = 'reports'; ?>
<?php include '../sidebar/sidebar.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Clinic Reports & Analytics</title>

<style>
/* ---------- GLOBAL STYLING ---------- */
:root {
    --primary-maroon: #800000;
    --light-bg: #f8f8f8;
    --box-shadow: 0 4px 10px rgba(0,0,0,0.15);
}

body {
    margin: 0;
    background: var(--light-bg);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.main-content {
    margin-left: 250px;
    padding: 30px 40px;
    min-height: 100vh;
}

h2 {
    color: var(--primary-maroon);
    text-align: center;
    margin-bottom: 18px;
    font-weight: 700;
    letter-spacing: 0.5px;
}

section {
    margin: 0 auto 35px auto;
    max-width: 900px;
}

/* ---------- TABLE STYLE ---------- */
table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: var(--box-shadow);
}

th, td {
    padding: 12px;
    border: 1px solid #eaeaea;
    text-align: center;
    font-size: 0.95rem;
}

th {
    background: var(--light-bg);
    color: var(--primary-maroon);
    font-weight: 700;
    border-bottom: 2px solid var(--primary-maroon);
}

tr:nth-child(even) { background: #f7fbfc; }
tr:hover { background: #ffeaea; }

/* ---- Styled Dropdown Filter ---- */
.filter-box {
    text-align: center;
    margin-bottom: 25px;
}

.filter-form {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: #fff;
    padding: 12px 20px;
    border-radius: 10px;
    box-shadow: var(--box-shadow);
    border: 1px solid #e3e3e3;
}

.filter-form label {
    color: var(--primary-maroon);
    font-weight: 700;
    font-size: 0.95rem;
}

.filter-form select {
    padding: 10px 14px;
    border-radius: 8px;
    border: 2px solid #ddd;
    font-size: 0.95rem;
    font-weight: 600;
    background: #fafafa;
    transition: 0.25s ease;
}

.filter-form select:hover {
    border-color: var(--primary-maroon);
    background: #fff3f3;
}

.filter-form select:focus {
    outline: none;
    border-color: var(--primary-maroon);
    box-shadow: 0 0 6px rgba(128,0,0,0.3);
}

@media (max-width: 1200px) {
    .main-content { margin-left: 0; padding: 18px; }
    table { width: 100%; }
}
</style>
</head>

<body>
<div class="main-content">

<!-- ========================================== -->
<!-- FILTER BAR                                 -->
<!-- ========================================== -->
<h2>Summary Per Grade Level</h2>

<div class="filter-box">
    <form method="GET" class="filter-form">
        <label for="grade">Filter by Grade:</label>
        <select id="grade" name="grade" onchange="this.form.submit()">
            <option value="">Show All Grades</option>
            <option value="Grade 7"  <?= ($filterGrade=='Grade 7')?'selected':'' ?>>Grade 7</option>
            <option value="Grade 8"  <?= ($filterGrade=='Grade 8')?'selected':'' ?>>Grade 8</option>
            <option value="Grade 9"  <?= ($filterGrade=='Grade 9')?'selected':'' ?>>Grade 9</option>
            <option value="Grade 10" <?= ($filterGrade=='Grade 10')?'selected':'' ?>>Grade 10</option>
            <option value="Grade 11" <?= ($filterGrade=='Grade 11')?'selected':'' ?>>Grade 11</option>
            <option value="Grade 12" <?= ($filterGrade=='Grade 12')?'selected':'' ?>>Grade 12</option>
        </select>
    </form>
</div>

<!-- ========================================== -->
<!-- SUMMARY TABLE (PER GRADE TOP 1)           -->
<!-- ========================================== -->
<section>
<table>
    <tr>
        <th>Grade Level</th>
        <th>Section</th>
        <th>Top Complaint</th>
        <th>Student w/ Most Visits</th>
    </tr>

<?php foreach ($summary as $row): ?>
    <?php if ($filterGrade == "" || $filterGrade == $row['department']): ?>

        <?php
        // Get top complaint for this grade
        $topComplaint = $reports->top_complaint_by_grade($row['department']);

        // Get top student for this grade
        $topStudent = $reports->top_student_by_grade($row['department']);
        ?>

        <tr>
            <td><?= htmlspecialchars($row['department']) ?></td>
            <td><?= htmlspecialchars($row['section']) ?></td>

            <td><?= $topComplaint ? htmlspecialchars($topComplaint['complaint']) : "No Data" ?></td>

            <td><?= $topStudent ? htmlspecialchars($topStudent['name']) : "No Data" ?></td>
        </tr>

    <?php endif; ?>
<?php endforeach; ?>

</table>
</section>

<!-- ========================================== -->
<!-- MOST DISPENSED MEDICINES                  -->
<!-- ========================================== -->
<h2>Most Dispensed Medicines</h2>
<section>
<table>
    <tr><th>Medicine</th><th>Total Dispensed</th></tr>
    <?php foreach($topMeds as $m): ?>
        <tr>
            <td><?= htmlspecialchars($m['medicine']) ?></td>
            <td><?= htmlspecialchars($m['total_dispensed']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
</section>

<!-- ========================================== -->
<!-- VISITS PER MONTH                          -->
<!-- ========================================== -->
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

</div>

<script>
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>
