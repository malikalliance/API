<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate activite object
include_once '../objects/activite.php';

$database = new Database();
$db = $database->getConnection();

$activite = new Activite($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set activite property values
$activite->activite = $data->activite;

// create the activite
if($activite->create()){
    echo json_encode(
        array("message" => "good")
    );
}

// if unable to create the activite, tell the user
else{
    echo json_encode(
        array("message" => "false")
    );
}
?>