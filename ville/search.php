<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/ville.php';

// instantiate database and ville object
$database = new Database();
$db = $database->getConnection();

// initialize object
$ville = new Ville($db);

// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// query villes
$stmt = $ville->search($keywords);
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // villes array
    $villes_arr=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $ville_item=array(
            "id" => $id,
            "nom_ville" => $nom_ville
        );

        array_push($villes_arr, $ville_item);
    }

    echo json_encode(
        array("message" => "good", "villes" => $villes_arr)
    );
}

else{
    echo json_encode(
        array("message" => "false")
    );
}
?>