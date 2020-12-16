<?php
function import_csv_to_sqlite(&$pdo, $csv_path,$filename,$file_empty)
{

    if (($csv_handle = fopen($csv_path, "r")) === FALSE)
        throw new Exception('Cannot open CSV file');

    if(!isset($delimiter))
        $delimiter = ';';

    if(!isset($table))
        $table = preg_replace("/[^A-Z0-9]/i", '', basename($csv_path));

    if(!isset($fields)){
        $fields = array_map(function ($field){
            return strtolower(preg_replace("/results\//i", '', $field));
        }, fgetcsv($csv_handle, 0, $delimiter));
    }
    array_push($fields,'id');
    $create_fields_str = join(', ', array_map(function ($field){
        return "$field VARCHAR(255) NOT NULL";
    }, $fields));

    $pdo->beginTransaction();

    $create_table_sql = "CREATE TABLE IF NOT EXISTS $table ($create_fields_str)";
    $pdo->exec($create_table_sql);
    if($file_empty){
    $insert_fields_str = join(', ', $fields);
    $insert_values_str = join(', ', array_fill(0, count($fields),  '?'));
    $insert_sql = "INSERT INTO $table ($insert_fields_str) VALUES ($insert_values_str)";
    $insert_sth = $pdo->prepare($insert_sql);
    $inserted_rows = 0;
    $key = 0;
    while (($data = fgetcsv($csv_handle, 0, $delimiter = ";")) !== FALSE) {
        array_push($data,$key);
        $insert_sth->execute($data);
        $inserted_rows++;
        $key++;
    }
    $pdo->commit();
    }
    $query_select = "SELECT * FROM $table";
    $res = $pdo->query($query_select)->fetchAll(\PDO::FETCH_ASSOC);
    $res['column_names'] = $fields;
    return json_encode($res);

}
$filename = "database.SQLite";
$pdo = new PDO("sqlite:".__DIR__."/".$filename);
$file_empty;
if(filesize($filename) == 0){
    $file_empty = true;
}
else{
    $file_empty = false;
}
print_r(import_csv_to_sqlite($pdo,"naves.csv",$filename,$file_empty));
?>