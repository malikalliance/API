<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/rapport.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare rapport object
$rapport = new Rapport($db);

// set id_client and date of rapport searched
$rapport->id_client = isset($_GET['id_client']) ? $_GET['id_client'] : die();
$rapport->mois = isset($_GET['mois']) ? $_GET['mois'] : die();

$stmt = $rapport->readForOneClient();
$num = $stmt->execute();


// check if more than 0 record found
if($num>0){

    // rapport array
    $rapport_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $rapport_item=array(
            "id" => $id,
            "id_client" => $id_client,
            "enseigne" => $enseigne,
            "id_ville" => $id_ville,
            "nom_ville" => $nom_ville,
            "id_activite" => $id_activite,
            "activite" => $activite,
            "position_mot_clef" => $position_mot_clef,
            "date_creation" => $date_creation,
        );

        array_push($rapport_arr, $rapport_item);
    }

    echo json_encode(
        array("message" => "good", "rapport" => $rapport_arr)
    );
}

else{
    echo json_encode(
        array("message" => "false")
    );
}

?>