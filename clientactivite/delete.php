<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// include database and object file
include_once '../config/database.php';
include_once '../objects/clientactivite.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare client_activite object
$client_activite = new ClientActivite($db);

// get client_activite id
$data = json_decode(file_get_contents("php://input"));

// set client_activite id to be deleted
$client_activite->id_client = $data->id_client;
$client_activite->id_activite = $data->id_activite;

// delete the client_activite
if($client_activite->delete()){
    echo json_encode(
        array("message" => "good")
    );
}

// if unable to delete the client_activite
else{
    echo json_encode(
        array("message" => "false")
    );
}
?>
