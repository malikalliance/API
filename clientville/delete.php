<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// include database and object file
include_once '../config/database.php';
include_once '../objects/clientville.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare client_ville object
$client_ville = new ClientVille($db);

// get client_ville id
$data = json_decode(file_get_contents("php://input"));

// set client_ville id to be deleted
$client_ville->id_client = $data->id_client;
$client_ville->id_ville = $data->id_ville;

// delete the client_ville
if($client_ville->delete()){
    echo json_encode(
        array("message" => "good")
    );
}

// if unable to delete the client_ville
else{
    echo json_encode(
        array("message" => "false")
    );
}
?>
