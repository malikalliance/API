<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/client.php';

// instantiate database and client object
$database = new Database();
$db = $database->getConnection();

// initialize object
$client = new Client($db);

// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// query clients
$stmt = $client->search($keywords);
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // clients array
    $clients_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $client_item = array(
            "id" => $id,
            "enseigne" => $enseigne,
            "url_becom" => $url_becom,
            "mois_signature" => $mois_signature,
            "annee_signature" => $annee_signature,
            "civilite" => $civilite,
            "nom_gerant" => $nom_gerant,
            "prenom_gerant" => $prenom_gerant,
            "email" => $email,
            "adresse" => $adresse,
            "ville" => $ville,
            "cp" => $cp,
            "tel" => $tel,
            "interlocuteur_nom" => $interlocuteur_nom,
            "interlocuteur_prenom" => $interlocuteur_prenom,
            "type_site" => $type_site
        );

        array_push($clients_arr, $client_item);
    }

    echo json_encode(array("message" => "good", "clients" => $clients_arr));
}

else {
    echo json_encode(
        array("message" => "false")
    );
}
?>