<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate client object
include_once '../objects/client.php';

$database = new Database();
$db = $database->getConnection();

$client = new Client($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set client property values
$client->enseigne = $data->enseigne;
$client->url_becom = $data->url_becom;
$client->mois_signature = $data->mois_signature;
$client->annee_signature = $data->annee_signature;
$client->civilite = $data->civilite;
$client->nom_gerant = $data->om_gerant;
$client->prenom_gerant = $data->prenom_gerant;
$client->email = $data->email;
$client->adresse = $data->adresse;
$client->ville = $data->ville;
$client->cp = $data->cp;
$client->tel = $data->tel;
$client->interlocuteur_nom = $data->interlocuteur_nom;
$client->interlocuteur_prenom = $data->interlocuteur_prenom;
$client->type_site = $data->type_site;

// create the client
if($client->create()){
    echo json_encode(
        array("message" => "good")
    );
}

// if unable to create the client, tell the user
else{
    echo json_encode(
        array("message" => "false")
    );
}
?>