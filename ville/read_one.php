<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/ville.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare ville object
$ville = new Ville($db);

// set ID property of ville to be edited
$ville->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of ville to be edited
$ville->readOne();

// create array
$ville_arr = array(
    "id" =>  $ville->id,
    "nom_ville" => $ville->nom_ville

);

if (is_null($ville->nom_ville)) {
    echo json_encode(
        array("message" => "false")
    );
}
else {
    echo json_encode(
        array("message" => "good", "ville" => $ville_arr)
    );
}

?>