<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/client.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare client object
$client = new Client($db);

// get id of client to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of client to be edited
$client->id = $data->id;

// set client property values
$client->enseigne = $data->enseigne;
$client->url_becom = $data->url_becom;
$client->mois_signature = $data->mois_signature;
$client->annee_signature = $data->annee_signature;
$client->civilite = $data->civilite;
$client->nom_gerant = $data->nom_gerant;
$client->prenom_gerant = $data->prenom_gerant;
$client->email = $data->email;
$client->adresse = $data->adresse;
$client->ville = $data->ville;
$client->cp = $data->cp;
$client->tel = $data->tel;
$client->interlocuteur_nom = $data->interlocuteur_nom;
$client->interlocuteur_prenom = $data->interlocuteur_prenom;
$client->type_site = $data->type_site;

// update the client
if($client->update()){
    echo json_encode(
        array("message" => "good")
    );
}

// if unable to update the client, tell the user
else{
    echo json_encode(
        array("message" => "false")
    );
}
?>