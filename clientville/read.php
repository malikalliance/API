<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/clientville.php';

// instantiate database and client_ville object
$database = new Database();
$db = $database->getConnection();

// initialize object
$client_ville = new Clientville($db);
$client_ville->id_client = isset($_GET['id_client']) ? $_GET['id_client'] : die();

// query client_ville
$stmt = $client_ville->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // villes array
    $client_ville_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $client_ville_item=array(
            "id_ville" => $id_ville,
            "id_client" => $id_client,
            "nom_ville" => $nom_ville
        );

        array_push($client_ville_arr, $client_ville_item);
    }

    echo json_encode(
        array("message" => "good", "clientvilles" => $client_ville_arr)
    );
}

else{
    echo json_encode(
        array("message" => "false")
    );
}
?>