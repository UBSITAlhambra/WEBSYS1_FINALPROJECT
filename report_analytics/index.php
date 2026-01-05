<?php
// 1. INCLUDE THE GUARD FIRST
include '../login/auth_guard.php'; 

include "oop.php";
$reports = new reports();

// 2. FETCH ANALYTICS
$topMeds = $reports->top_medicines();
$monthlyVisits = $reports->visits_per_month();
$topComplaints = $reports->top_complaints();
$topStudents = $reports->top_students();
$summary = $reports->get_summary_by_department();

$filterGrade = isset($_GET['grade']) ? $_GET['grade'] : "";

$activePage = 'reports'; 
include '../sidebar/sidebar.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Reports Summary</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-maroon: #800000;
            --accent-maroon: #a52a2a;
            --bg-gray: #f4f7f6;
            --text-dark: #333;
            --card-shadow: 0 4px 20px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
        }

        body {
            margin: 0;
            background: var(--bg-gray);
            font-family: 'Inter', 'Segoe UI', sans-serif;
            color: var(--text-dark);
        }

        .main-content {
            margin-left: 250px; /* Aligned with your sidebar width */
            padding: 40px;
            transition: var(--transition);
        }

        /* Header Section */
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .dashboard-header h1 {
            color: var(--primary-maroon);
            font-size: 1.8rem;
            margin: 0;
            font-weight: 800;
        }

        /* Filter Styling */
        .filter-container {
            background: #fff;
            padding: 15px 25px;
            border-radius: 12px;
            box-shadow: var(--card-shadow);
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .filter-container label {
            font-weight: 600;
            color: #666;
        }

        .filter-container select {
            padding: 10px 15px;
            border: 2px solid #eee;
            border-radius: 8px;
            outline: none;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.95rem;
        }

        .filter-container select:hover { border-color: var(--primary-maroon); }

        /* Card System */
        .report-card {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            box-shadow: var(--card-shadow);
            margin-bottom: 30px;
            border-top: 4px solid var(--primary-maroon);
        }

        .card-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            color: var(--primary-maroon);
            font-size: 1.2rem;
            font-weight: 700;
        }

        /* Grid Layout for smaller tables */
        .reports-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        /* Table Modernization */
        .styled-table {
            width: 100%;
            border-collapse: collapse;
        }

        .styled-table thead tr {
            background-color: #fcfcfc;
            color: var(--primary-maroon);
            text-align: left;
        }

        .styled-table th, .styled-table td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .styled-table tbody tr:hover {
            background-color: #fff9f9;
        }

        /* Badge Styles */
        .badge {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        .badge-complaint { background: #fff0f0; color: #d00000; }
        .badge-student { background: #f0f4ff; color: #0047ab; }

        /* Responsive */
        @media (max-width: 1100px) {
            .reports-grid { grid-template-columns: 1fr; }
            .main-content { margin-left: 0; padding: 20px; }
        }
    </style>
</head>

<body>
    <div class="main-content">
        
        <header class="dashboard-header">
            <div>
                <h1><i class="fas fa-chart-line"></i> Clinic Reports Summary</h1>
                <p style="color: #888; margin-top: 5px;">Summary of student clinic visits</p>
            </div>
            
            <form method="GET" class="filter-container">
                <label for="grade"><i class="fas fa-filter"></i> Filter</label>
                <select id="grade" name="grade" onchange="this.form.submit()">
                    <option value="">All Grade Levels</option>
                    <?php for($i=7; $i<=12; $i++): ?>
                        <option value="Grade <?= $i ?>" <?= ($filterGrade=="Grade $i")?'selected':'' ?>>Grade <?= $i ?></option>
                    <?php endfor; ?>
                </select>
            </form>
        </header>

        <section class="report-card">
            <div class="card-title">
                <i class="fas fa-table"></i> Grade Level Performance Summary
            </div>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Grade Level</th>
                        <th>Section</th>
                        <th>Top Complaint</th>
                        <th>Student w/ Most Visits</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($summary as $row): ?>
                        <?php if ($filterGrade == "" || $filterGrade == $row['department']): 
                            $topComplaint = $reports->top_complaint_by_grade($row['department']);
                            $topStudent = $reports->top_student_by_grade($row['department']);
                        ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($row['department']) ?></strong></td>
                                <td><?= htmlspecialchars($row['section']) ?></td>
                                <td>
                                    <span class="badge badge-complaint">
                                        <?= $topComplaint ? htmlspecialchars($topComplaint['complaint']) : "—" ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge badge-student">
                                        <?= $topStudent ? htmlspecialchars($topStudent['name']) : "—" ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <div class="reports-grid">
            
            <section class="report-card">
                <div class="card-title">
                    <i class="fas fa-pills"></i> Most Dispensed
                </div>
                <table class="styled-table">
                    <thead>
                        <tr><th>Medicine</th><th>Quantity</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($topMeds as $m): ?>
                            <tr>
                                <td><?= htmlspecialchars($m['medicine']) ?></td>
                                <td style="font-weight: bold; color: var(--primary-maroon);">
                                    <?= htmlspecialchars($m['total_dispensed']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <section class="report-card">
                <div class="card-title">
                    <i class="fas fa-calendar-alt"></i> Monthly Visit Trends
                </div>
                <table class="styled-table">
                    <thead>
                        <tr><th>Month</th><th>Total Visits</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach($monthlyVisits as $month): ?>
                            <tr>
                                <td><?= htmlspecialchars($month['month']) ?></td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <div style="background: #eee; flex-grow: 1; height: 8px; border-radius: 4px; overflow: hidden;">
                                            <div style="width: <?= min(($month['total_visits'] * 2), 100) ?>%; background: var(--accent-maroon); height: 100%;"></div>
                                        </div>
                                        <span><?= htmlspecialchars($month['total_visits']) ?></span>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

        </div>
    </div>

    <script>
        // Refresh check for back button
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</body>
</html>