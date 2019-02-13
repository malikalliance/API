<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/client.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare client object
$client = new Client($db);

// set ID property of client to be edited
$client->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of client to be edited
$client->readOne();

// create array
$client_arr = array(
    "id" => $client->id,
    "enseigne" => $client->enseigne,
    "url_becom" => $client->url_becom,
    "mois_signature" => $client->mois_signature,
    "annee_signature" => $client->annee_signature,
    "civilite" => $client->civilite,
    "nom_gerant" => $client->nom_gerant,
    "prenom_gerant" => $client->prenom_gerant,
    "email" => $client->email,
    "adresse" => $client->adresse,
    "ville" => $client->ville,
    "cp" => $client->cp,
    "tel" => $client->tel,
    "interlocuteur_nom" => $client->interlocuteur_nom,
    "interlocuteur_prenom" => $client->interlocuteur_prenom,
    "type_site" => $client->type_site
);

if (is_null($client->enseigne)) {
    echo json_encode(
        array("message" => "false")
    );
}
else {
    echo json_encode(
        array("message" => "good", "client" => $client_arr)
    );
}
?>