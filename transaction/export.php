<?php
    include 'oop.php';
    $oop = new oop_class();
    $data = $oop->show_data();
    $format = strtolower($_GET['format'] ?? 'csv');

    $base_name = $_GET['filename'] ?? 'transaction_export';
    $date_tag = date('Ymd_His');

    $clean_base_name = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $base_name);
    if (empty(trim($clean_base_name, '_'))) {
        $clean_base_name = 'transaction_export';
    }

    switch ($format) {
        case 'sql':
            $filename = $clean_base_name . '_' . $date_tag . '.sql';
            header('Content-Type: application/sql');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            $sql_content = "-- Exported Transaction Data\n";
            $sql_content .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
            $sql_content .= "START TRANSACTION;\n\n";

            $table_name = 'transaction';
            $columns = ['transactionID', 'quantity', 'transactionDate', 'itemID', 'studentID'];
            $column_list = implode(', ', $columns);

            $sql_content .= "/*!40000 ALTER TABLE `{$table_name}` DISABLE KEYS */; \n";
            
            $raw_data_stmt = $oop->get_connection()->query("SELECT * FROM transaction");
            $raw_data = $raw_data_stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($raw_data)) {
                foreach ($raw_data as $row) {
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
            $filename = $clean_base_name . '_' . $date_tag . '.json';
            header('Content-Type: application/json');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            echo json_encode($data, JSON_PRETTY_PRINT);
            break;

        case 'csv':
        default:
            $filename = $clean_base_name . '_' . $date_tag . '.csv';
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            $output = fopen('php://output', 'w');

            $header_row = ['ID', 'Quantity', 'Date', 'Medicine Name', 'Student Name'];
            fputcsv($output, $header_row);

            if (!empty($data)) {
                foreach ($data as $row) {
                    $csv_row = [
                        $row['transactionID'],
                        $row['quantity'],
                        $row['transactionDate'],
                        $row['medicineName'],
                        $row['studentName']
                    ];
                    fputcsv($output, $csv_row);
                }
            }
            fclose($output);
            break;
    }
    exit();
?>