<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/rapport.php';

// instantiate database and rapport object
$database = new Database();
$db = $database->getConnection();

// initialize object
$rapport = new Rapport($db);

// query rapport
$stmt = $rapport->read();
$num = $stmt->rowCount();

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
            "id_ville" => $id_ville,
            "id_activite" => $id_activite,
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