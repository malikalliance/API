<?php
class ClientVille{

    // database connection and table name
    private $conn;
    private $table_name = "clientville";

    // object properties
    public $id_client;
    public $id_ville;
    public $nom_ville;

    public function __construct($db){
        $this->conn = $db;
    }

    // used by select drop-down list
    public function read(){

        $query = "SELECT distinct cv.id_ville, cv.id_client, v.nom_ville FROM ville v, clientville cv, client c 
                    WHERE v.id=cv.id_ville AND cv.id_client=:id_client" ;

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_client=htmlspecialchars(strip_tags($this->id_client));

        // bind values
        $stmt->bindParam(":id_client", $this->id_client);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // create clientville
    function create(){

        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET id_client=:id_client, id_ville=:id_ville";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_client=htmlspecialchars(strip_tags($this->id_client));
        $this->id_ville=htmlspecialchars(strip_tags($this->id_ville));

        // bind values
        $stmt->bindParam(":id_client", $this->id_client);
        $stmt->bindParam(":id_ville", $this->id_ville);

        // execute query
        if($stmt->execute()) return true;

        return false;
    }


    // delete the clientville
    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id_client=:id_client AND id_ville=:id_ville";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_client=htmlspecialchars(strip_tags($this->id_client));
        $this->id_ville=htmlspecialchars(strip_tags($this->id_ville));

        // bind values
        $stmt->bindParam(":id_client", $this->id_client);
        $stmt->bindParam(":id_ville", $this->id_ville);

        // execute query
        if($stmt->execute()) return true;

        return false;
    }

}
?>