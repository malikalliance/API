<?php
class ClientActivite{

    // database connection and table name
    private $conn;
    private $table_name = "clientactivite";

    // object properties
    public $id_client;
    public $id_activite;
    public $activite;

    public function __construct($db){
        $this->conn = $db;
    }

    // used by select drop-down list
    public function read(){
        //select all data
        //$query = "SELECT * FROM " . $this->table_name . " WHERE id_client=:id_client" ;
        $query = "SELECT distinct ca.id_activite, ca.id_client, a.activite FROM activite a, clientactivite ca, client c 
                    WHERE a.id=ca.id_activite AND ca.id_client=:id_client" ;

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

    // create clientactivite
    function create(){

        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET id_client=:id_client, id_activite=:id_activite";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_client=htmlspecialchars(strip_tags($this->id_client));
        $this->id_activite=htmlspecialchars(strip_tags($this->id_activite));

        // bind values
        $stmt->bindParam(":id_client", $this->id_client);
        $stmt->bindParam(":id_activite", $this->id_activite);

        // execute query
        if($stmt->execute()) return true;

        return false;
    }


    // delete the clientactivite
    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id_client=:id_client AND id_activite=:id_activite";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id_client=htmlspecialchars(strip_tags($this->id_client));
        $this->id_activite=htmlspecialchars(strip_tags($this->id_activite));

        // bind values
        $stmt->bindParam(":id_client", $this->id_client);
        $stmt->bindParam(":id_activite", $this->id_activite);

        // execute query
        if($stmt->execute()) return true;

        return false;
    }

}
?>