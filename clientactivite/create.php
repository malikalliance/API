<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate client-activite object
include_once '../objects/clientactivite.php';

$database = new Database();
$db = $database->getConnection();

$client_activite = new ClientActivite($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set client_activite property values
$client_activite->id_client = $data->id_client;
$client_activite->id_activite = $data->id_activite;

// create the client_activite
if($client_activite->create()){
    echo json_encode(
        array("message" => "good")
    );
}

// if unable to create the client_activite, tell the user
else{
    echo json_encode(
        array("message" => "false")
    );
}
?>