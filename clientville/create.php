<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate client-ville object
include_once '../objects/clientville.php';

$database = new Database();
$db = $database->getConnection();

$client_ville = new Clientville($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set client_ville property values
$client_ville->id_client = $data->id_client;
$client_ville->id_ville = $data->id_ville;

// create the client_ville
if($client_ville->create()){
    echo json_encode(
        array("message" => "good")
    );
}

// if unable to create the client_ville, tell the user
else{
    echo json_encode(
        array("message" => "false")
    );
}
?>