<?php
include 'oop.php';
$oop = new oop_class();
// We use the new dedicated function to fetch comprehensive data for export
$data = $oop->get_export_data(); 
$format = strtolower($_GET['format'] ?? 'csv');

$base_name = $_GET['filename'] ?? 'clinic_records_dispensing';
$clean_base_name = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $base_name);
$final_name_base = empty(trim($clean_base_name, '_')) ? 'Treatment Records' : $clean_base_name;


switch ($format) {
    case 'sql':
        $filename = $final_name_base . '.sql';
        header('Content-Type: application/sql');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $sql_content = "-- Exported Transaction Data\n";
        $sql_content .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
        $sql_content .= "START TRANSACTION;\n\n";

        $table_name = 'transaction';
        // Columns needed for raw INSERT statements (must match the database structure)
        $columns = ['transactionID', 'quantity', 'transactionDate', 'itemID', 'studentID', 'remarks'];
        $column_list = implode(', ', $columns);

        $sql_content .= "/*!40000 ALTER TABLE `{$table_name}` DISABLE KEYS */; \n";
        
        // Refetching only base transaction data for accurate SQL INSERT statements
        // NOTE: This assumes oop_class has a getDbConnection() method for raw queries
        $raw_data_stmt = $oop->get_connection()->query("SELECT " . implode(', ', $columns) . " FROM transaction ORDER BY transactionID ASC");
        $base_data = $raw_data_stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($base_data)) {
            foreach ($base_data as $row) {
                $values = array_map(function($value) {
                    if (is_numeric($value)) { return $value; }
                    if ($value === null || $value === '') { return 'NULL'; }
                    return "'" . str_replace("'", "''", $value) . "'"; 
                }, array_values($row));

                $value_list = implode(', ', $values);
                $sql_content .= "INSERT INTO `{$table_name}` ({$column_list}) VALUES ({$value_list});\n";
            }
        }
        $sql_content .= "\n/*!40000 ALTER TABLE `{$table_name}` ENABLE KEYS */; \n";
        $sql_content .= "COMMIT;\n";
        echo $sql_content;
        break;

    case 'json':
        $filename = $final_name_base . '.json';
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        // JSON uses the comprehensive array directly
        echo json_encode($data, JSON_PRETTY_PRINT);
        break;

    case 'csv':
    default:
        $filename = $final_name_base . '.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $output = fopen('php://output', 'w');

        // --- CSV HEADER MATCHING DISPLAYED DATA (Includes new Student Fields) ---
        $header_row = [
            'DATE', 
            'NAME',
            'YEAR & SECTION', 
            'SEX',
            'ROLE',
            'COMPLAINTS',
            'MEDICINE DISPENSED', 
            'QTY', 
            'REMARKS'
        ];
        fputcsv($output, $header_row);

        if (!empty($data)) {
            foreach ($data as $row) {
                // Manually map fields to match the layout
                $csv_row = [
                    $row['transactionDate'] ?? '',
                    $row['studentName'] ?? '',
                    trim(($row['department'] ?? '') . ' ' . ($row['section'] ?? '')),
                    $row['gender'] ?? '',
                    $row['role'] ?? '',
                    $row['complaint'] ?? '',
                    $row['medicineName'] ?? '',
                    $row['quantity'] ?? '', 
                    $row['remarks'] ?? ''
                ];
                fputcsv($output, $csv_row);
            }
        }
        fclose($output);
        break;
}
exit();
?>