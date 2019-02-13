<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/activite.php';

// instantiate database and activite object
$database = new Database();
$db = $database->getConnection();

// initialize object
$activite = new Activite($db);

// query activites
$stmt = $activite->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // activites array
    $activites_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $activite_item=array(
            "id" => $id,
            "activite" => $activite
        );

        array_push($activites_arr, $activite_item);
    }

    echo json_encode(
        array("message" => "good", "activites" => $activites_arr)
    );
}

else{
    echo json_encode(
        array("message" => "false")
    );
}
?>