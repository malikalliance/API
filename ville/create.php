<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate ville object
include_once '../objects/ville.php';

$database = new Database();
$db = $database->getConnection();

$ville = new Ville($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set ville property values
$ville->nom_ville = $data->nom_ville;

// create the ville
if($ville->create()){
    echo json_encode(
        array("message" => "good", "nom_ville" => $data->nom_ville)
    );
}

// if unable to create the ville, tell the user
else{
    echo json_encode(
        array("message" => "false")
    );
}
?>