<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// include database and object file
include_once '../config/database.php';
include_once '../objects/activite.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare activite object
$activite = new Activite($db);

// get activite id
$data = json_decode(file_get_contents("php://input"));

// set activite id to be deleted
$activite->id = $data->id;

// delete the activite
if($activite->delete()){
    echo json_encode(
        array("message" => "good")
    );
}

// if unable to delete the activite
else{
    echo json_encode(
        array("message" => "false")
    );
}
?>
