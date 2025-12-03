<?php
session_start();
include "oop.php";
$oop = new oop_class();
$activePage = 'inventory';
include '../sidebar/sidebar.php';
    if(!isset($_SESSION['user_id'])){
        header('Location: ../login/');
    }
$show_update_data = null;
if (isset($_GET['id'])) {
    $ID = $_GET['id'];
    $show_update_data = $oop->show_update_data($ID);
}

if (isset($_POST['enter'])) {
    $genericName = $_POST['genericName'] ?? '';
    $dosage      = $_POST['dosage'] ?? '';
    $category    = $_POST['category'] ?? '';
    $addDate     = $_POST['addDate'] ?? '';
    $expDate     = $_POST['expDate'] ?? '';
    $quantity    = $_POST['quantity'] ?? '';
    $ID          = $_POST['id'] ?? '';
    $oop->update_data($genericName, $dosage, $category, $quantity, $addDate, $expDate, $ID);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Update Inventory Item</title>
<style>
:root { --primary-maroon:#800000; --light-bg:#f8f8f8; --box-shadow:0 4px 10px rgba(0,0,0,.15); --cancel-gray:#6c757d; }
body { margin:0; font-family:'Segoe UI', Arial, sans-serif; background:var(--light-bg); }
.main-content { margin-left:250px; padding:40px; min-height:100vh; }
.form-wrapper { max-width:560px; margin:0 auto; }
.card { background:#fff; padding:35px 40px; border-radius:12px; box-shadow:var(--box-shadow); }
h1 { color:var(--primary-maroon); font-size:1.8rem; text-align:center; margin-bottom:26px; font-weight:600; }
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:20px; }
.form-group { display:flex; flex-direction:column; gap:8px; }
label { color:#555; font-weight:600; font-size:.95rem; }
input[type="text"], input[type="date"], input[type="number"], select {
  width:100%; padding:12px 15px; border:1.5px solid #ddd; border-radius:8px; font-size:1rem; box-sizing:border-box;
}
input:focus, select:focus { outline:none; border-color:var(--primary-maroon); box-shadow:0 0 8px rgba(128,0,0,.2); }
.button-group { display:flex; gap:15px; margin-top:24px; }
.btn { flex:1; padding:14px 20px; border:none; border-radius:8px; font-size:1rem; font-weight:600; cursor:pointer; text-align:center; text-decoration:none; }
.btn-update { background:var(--primary-maroon); color:#fff; }
.btn-update:hover { background:#a00000; }
.btn-cancel { background:var(--cancel-gray); color:#fff; display:inline-block; }
.btn-cancel:hover { background:#545b62; }
.no-data { background:#fff; padding:20px; border-radius:12px; box-shadow:var(--box-shadow); color:var(--primary-maroon); font-weight:bold; text-align:center; }
@media(max-width:700px){ .main-content{margin-left:0;padding:20px;} .form-row{grid-template-columns:1fr;} }
</style>
</head>
<body>
<div class="main-content">
  <div class="form-wrapper">
    <div class="card">
      <h1>Update Inventory Item</h1>
      <?php if (!empty($show_update_data)): $row = $show_update_data; ?>
      <form method="POST" action="">
        <div class="form-row">
          <div class="form-group">
            <label>Generic Name</label>
            <input type="text" name="genericName" value="<?= htmlspecialchars($row['genericName']) ?>" required>
          </div>
          <div class="form-group">
            <label>Dosage</label>
            <input type="text" name="dosage" value="<?= htmlspecialchars($row['dosage']) ?>" required>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Category</label>
            <select name="category" required>
              <option value="Pain Relief" <?= $row['category']=='Pain Relief'?'selected':'' ?>>Pain Relief</option>
              <option value="Fever" <?= $row['category']=='Fever'?'selected':'' ?>>Fever</option>
              <option value="Allergy" <?= $row['category']=='Allergy'?'selected':'' ?>>Allergy</option>
              <option value="Wound Care" <?= $row['category']=='Wound Care'?'selected':'' ?>>Wound Care</option>
              <option value="Other" <?= $row['category']=='Other'?'selected':'' ?>>Other</option>
            </select>
          </div>
          <div class="form-group">
            <label>Quantity</label>
            <input type="number" name="quantity" value="<?= htmlspecialchars($row['quantity']) ?>" required min="0">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label>Add Date</label>
            <input type="date" name="addDate" value="<?= htmlspecialchars($row['addDate']) ?>" required>
          </div>
          <div class="form-group">
            <label>Expiry Date</label>
            <input type="date" name="expDate" value="<?= htmlspecialchars($row['expDate']) ?>" required>
          </div>
        </div>
        <input type="hidden" name="id" value="<?= htmlspecialchars($row['itemID']) ?>">
        <div class="button-group">
          <a href="index.php" class="btn btn-cancel">Cancel</a>
          <button name="enter" class="btn btn-update">Update Details</button>
        </div>
      </form>
      <?php else: ?>
        <p class="no-data">No inventory item found for this ID.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
