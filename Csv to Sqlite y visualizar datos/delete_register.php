<?php
if(isset($_POST['id'])){
   $filename = "database.SQLite";
    $table = "navescsv";
    $pdo = new PDO("sqlite:".__DIR__."/".$filename);
    $pdo->beginTransaction();
    $id = $_POST['id'];
    $query_delete = "DELETE FROM `$table` WHERE id = $id";
    $pdo->exec($query_delete);
    $pdo->commit();
    print_r(json_encode(array('response'=>true)));
}
else{
    die("You must pass post var `id` to delete register");
}

?>