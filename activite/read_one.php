<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/activite.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare activite object
$activite = new Activite($db);

// set ID property of activite to be edited
$activite->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of activite to be edited
$activite->readOne();

// create array
$activite_arr = array(
    "id" =>  $activite->id,
    "activite" => $activite->activite
);

if (is_null($activite->activite)) {
    echo json_encode(
        array("message" => "false")
    );
}
else {
    echo json_encode(
        array("message" => "good", "activite" => $activite_arr)
    );
}
?>