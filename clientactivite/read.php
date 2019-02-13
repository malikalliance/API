<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/clientactivite.php';

// instantiate database and client_activite object
$database = new Database();
$db = $database->getConnection();

// initialize object
$client_activite = new ClientActivite($db);
$client_activite->id_client = isset($_GET['id_client']) ? $_GET['id_client'] : die();

// query client_activite
$stmt = $client_activite->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // activites array
    $client_activite_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $client_activite_item=array(
            "id_activite" => $id_activite,
            "id_client" => $id_client,
            "activite" => $activite
        );

        array_push($client_activite_arr, $client_activite_item);
    }

    echo json_encode(
        array("message" => "good", "clientactivites" => $client_activite_arr)
    );
}

else{
    echo json_encode(
        array("message" => "false")
    );
}
?>