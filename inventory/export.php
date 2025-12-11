<?php
    include 'oop.php';
    $inventory = new oop_class();
    $data = $inventory->show_data(); 
    $format = strtolower($_GET['format'] ?? 'csv');
    $base_name = $_GET['filename'] ?? 'inventory_export';
    $clean_base_name = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $base_name);
    $final_name_base = empty(trim($clean_base_name, '_')) ? 'Inventory' : $clean_base_name;

    switch ($format) {
        case 'sql':
            $filename = $final_name_base . '.sql';
            header('Content-Type: application/sql');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            $sql_content = "-- Exported Inventory Data from WEBSYS1_FINALPROJECT\n";
            $sql_content .= "-- Host: " . SERVER . "\n";
            $sql_content .= "-- Database: " . DBNAME . "\n\n";
            $sql_content .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
            $sql_content .= "START TRANSACTION;\n\n";
            $table_name = 'inventory';
            $columns = ['itemID', 'genericName', 'dosage', 'quantity', 'category', 'addDate', 'expDate'];
            $column_list = implode(', ', $columns);
            $sql_content .= "/*!40000 ALTER TABLE `{$table_name}` DISABLE KEYS */; \n";
            if (!empty($data)) {
                foreach ($data as $row) {
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
            echo json_encode($data, JSON_PRETTY_PRINT);
            break;

        case 'csv':
        default:
            $filename = $final_name_base . '.csv';
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            $output = fopen('php://output', 'w');
            $header_row = ['ID', 'Generic Name', 'Dosage', 'Quantity', 'Category', 'Added Date', 'Expiry Date'];
            fputcsv($output, $header_row);
            if (!empty($data)) {
                foreach ($data as $row) {
                    $csv_row = [$row['itemID'], $row['genericName'], $row['dosage'], $row['quantity'], $row['category'], $row['addDate'], $row['expDate']];
                    fputcsv($output, $csv_row);
                }
            }
            fclose($output);
            break;
    }
    exit();
?>