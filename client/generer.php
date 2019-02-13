<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/client.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$client = new Client($db);

// query products
$stmt = $client->generer();
$num = $stmt->rowCount();

// check if more than 0 record found
if ($num > 0) {

    // clients array
    $clients_arr = array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $client_item = array(
            "id" => $id,
            "nom" => $enseigne,
            "url" => $url_becom,
            "id_activite" => $id_activite,
            "activite" => $activite,
            "id_ville" => $id_ville,
            "ville" => $nom_ville
        );

        array_push($clients_arr, $client_item);
    }


    $before = $clients_arr[0]['nom'];
    $url = $clients_arr[0]['url'];
    $id = $clients_arr[0]['id'];
    $to_return = array();
    $mots_clefs_arr = array();
    $tab = array();
    $i = 0;

    foreach ($clients_arr as $c) {
        $i++;
        if ((strcmp($before, $c['nom']) == 0) or ($i == sizeof($clients_arr))) {
            array_push($mots_clefs_arr, array(
                "id_activite" => $c['id_activite'],
                "id_ville" => $c['id_ville'],
                "mot_clef" => $c['activite'] . ' ' . $c['ville']
            ));
        } else {
            $tab = array(
                "id" => $id,
                "nom" => $before,
                "url" => $url,
                "mots_clefs" => $mots_clefs_arr
            );
            array_push($to_return, $tab);
            $mots_clefs_arr = array();
            $id = $c['id'];
            $url = $c['url'];
            $before = $c['nom'];
            array_push($mots_clefs_arr, array(
                "id_activite" => $c['id_activite'],
                "id_ville" => $c['id_ville'],
                "mot_clef" => $c['activite'] . ' ' . $c['ville']
            ));
        }
    }

    $tab = array(
        "id" => $id,
        "nom" => $before,
        "url" => $url,
        "mots_clefs" => $mots_clefs_arr
    );

    array_push($to_return, $tab);
    echo json_encode(
        array($to_return)
    );
} else {
    echo json_encode(array("message" => "false"));
}
?>