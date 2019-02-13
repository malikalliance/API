<?php
class Rapport{

    // database connection and table name
    private $conn;
    private $table_name = "rapport";

    // object properties
    public $id;
    public $id_client;
    public $id_ville;
    public $id_activite;
    public $position_mot_clef;
    public $date_creation;

    public $mois;

    public function __construct($db){
        $this->conn = $db;
    }


    // create rapport
    function create(){

        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET id_client=:id_client, id_ville=:id_ville, 
                id_activite=:id_activite, position_mot_clef=:position_mot_clef, date_creation=NOW()";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_client=htmlspecialchars(strip_tags($this->id_client));
        $this->id_ville=htmlspecialchars(strip_tags($this->id_ville));
        $this->id_activite=htmlspecialchars(strip_tags($this->id_activite));
        $this->position_mot_clef=htmlspecialchars(strip_tags($this->position_mot_clef));


        // bind values
        $stmt->bindParam(":id_client", $this->id_client);
        $stmt->bindParam(":id_ville", $this->id_ville);
        $stmt->bindParam(":id_activite", $this->id_activite);
        $stmt->bindParam(":position_mot_clef", $this->position_mot_clef);


        // execute query
        if($stmt->execute()) return true;

        return false;
    }

    // used by select drop-down list
    public function read(){

        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id ASC";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }


    // get all rapport for one client
    function readForOneClient(){

        $query = "SELECT DISTINCT r.id, r.id_client, c.enseigne, r.id_ville, v.nom_ville, r.id_activite, a.activite,
                  r.position_mot_clef, r.date_creation FROM rapport r, client c, ville v, activite a
                  WHERE r.id_client=:id_client AND MONTH(r.date_creation)=:mois AND r.id_ville=v.id AND r.id_client=c.id AND r.id_activite=a.id";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of client and date to get rapport
        $stmt->bindParam(':id_client', $this->id_client, PDO::PARAM_INT);
        $stmt->bindParam(':mois', $this->mois, PDO::PARAM_INT);


        return $stmt;
    }

}
?>