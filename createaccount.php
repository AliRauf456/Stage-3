<?php
//$database_file = "/Applications/XAMPP/xamppfiles/htdocs/Stage-3/";
$database_file="Stage3db";
$db = new PDOSQLite3(sqlite:$database_file);
if(!$db) {
    die("Connection failed: " . $db->lastErrorMsg());
}

$sql="select * From User";
$stmt=$conn->prepare($sql);
$stmt->execute();
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($rows){
    foreach ($rows as $row) {
        echo $row["firstname"];
        
    }}