<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate rapport object
include_once '../objects/rapport.php';

$database = new Database();
$db = $database->getConnection();

$rapport = new Rapport($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set rapport property values
$rapport->id_client = $data->id_client;
$rapport->id_ville = $data->id_ville;
$rapport->id_activite = $data->id_activite;
$rapport->position_mot_clef = $data->position_mot_clef;

// create the rapport
if($rapport->create()){
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