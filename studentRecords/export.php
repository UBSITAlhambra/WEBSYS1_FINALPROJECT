<?php
    include 'oop.php';
    $student = new oop_class();
    $data = $student->show_data(); 
    $format = strtolower($_GET['format'] ?? 'csv');
    $base_name = $_GET['filename'] ?? 'student_records_export';
    $clean_base_name = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $base_name);
    $final_name_base = empty(trim($clean_base_name, '_')) ? 'Clinic Records' : $clean_base_name;

    switch ($format) {
        case 'sql':
            $filename = $final_name_base . '.sql';
            header('Content-Type: application/sql');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            
            $sql_content = "-- Exported Student Records Data\n";
            $sql_content .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\n";
            $sql_content .= "START TRANSACTION;\n\n";

            $table_name = 'studentrecord';
            $columns = ['ID', 'name', 'idNum','role', 'department','section', 'complaint', 'visitDate'];
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

            $header_row = ['ID', 'Name', 'ID Number','Role', 'Department','Section', 'Complaint', 'Visit Date'];
            fputcsv($output, $header_row);

            if (!empty($data)) {
                foreach ($data as $row) {
                    $csv_row = [
                        $row['ID'], 
                        $row['name'], 
                        $row['idNum'], 
                        $row['role'],
                        $row['department'], 
                        $row['section'],
                        $row['complaint'], 
                        $row['visitDate']
                    ];
                    fputcsv($output, $csv_row);
                }
            }
            fclose($output);
            break;
    }
    exit();
?>