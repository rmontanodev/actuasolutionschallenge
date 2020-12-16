<?php 
checkPostVars();
    print_r($_POST);
   $filename = "database.SQLite";
    $table = "navescsv";
    $pdo = new PDO("sqlite:".__DIR__."/".$filename);
    $pdo->beginTransaction();
    $id = $_POST['id'];
    $fields = 'name,model,manufacturer,cost_in_credits,length,max_atmosphering_speed,crew,passengers,cargo_capacity,consumables,hyperdrive_rating,mglt,starship_class,created,edited,url,id';
    $values = implode("','",$_POST);
    print_r($values);
    $query_insert = "INSERT INTO $table ($fields) VALUES ('$values')";
    print_r($pdo->exec($query_insert));
    $pdo->commit();
    print_r(json_encode(array('response'=>true)));

function checkPostVars(){
    if(!isset($_POST['name']) || !isset($_POST['model']) || !isset($_POST['manufacturer']) || !isset($_POST['cost_in_credits']) || !isset($_POST['length']) || !isset($_POST['max_atmosphering_speed']) || !isset($_POST['crew']) || !isset($_POST['passengers']) || !isset( $_POST['cargo_capacity']) || !isset($_POST['consumables']) || !isset($_POST['hyperdrive_rating']) || !isset($_POST['mglt']) || !isset($_POST['starship_class']) || !isset($_POST['created']) || !isset($_POST['edited']) || !isset($_POST['url']) || !isset($_POST['id'])){
        die("You must pass all post vars to add new register");
    }
}
?>