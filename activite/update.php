<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/activite.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare activite object
$activite = new Activite($db);

// get id of activite to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of activite to be edited
$activite->id = $data->id;

// set activite property values
$activite->activite = $data->activite;

// update the activite
if($activite->update()){
    echo json_encode(
        array("message" => "good")
    );
}

// if unable to update the activite, tell the user
else{
    echo json_encode(
        array("message" => "false")
    );
}
?>