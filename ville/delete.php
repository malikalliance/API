<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// include database and object file
include_once '../config/database.php';
include_once '../objects/ville.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare ville object
$ville = new Ville($db);

// get ville id
$data = json_decode(file_get_contents("php://input"));

// set ville id to be deleted
$ville->id = $data->id;

// delete the ville
if($ville->delete()){
    echo json_encode(
        array("message" => "good")
    );
}

// if unable to delete the ville
else{
    echo json_encode(
        array("message" => "false")
    );
}
?>
