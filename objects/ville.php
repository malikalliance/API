<?php
class Ville{

    // database connection and table name
    private $conn;
    private $table_name = "ville";

    // object properties
    public $id;
    public $nom_ville;

    public function __construct($db){
        $this->conn = $db;
    }

    // used by select drop-down list
    public function read(){
        //select all data
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }

    // used when filling up the update ville form
    function readOne(){
        // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of ville to be updated
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->nom_ville=$row['nom_ville'];
    }

    // create ville
    function create(){

        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET nom_ville=:nom_ville";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->nom_ville=htmlspecialchars(strip_tags($this->nom_ville));

        // bind values
        $stmt->bindParam(":nom_ville", $this->nom_ville);

        // execute query
        if($stmt->execute()) return true;

        return false;
    }


    // update the ville
    function update(){

        // update query
        $query = "UPDATE " . $this->table_name . " SET
                nom_ville=:nom_ville
            WHERE
                id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->nom_ville=htmlspecialchars(strip_tags($this->nom_ville));

        // bind values
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(":nom_ville", $this->nom_ville);

        // execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // delete the ville
    function delete(){

        // delete query
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));

        // bind id of record to delete
        $stmt->bindParam(1, $this->id);

        // execute query
        if($stmt->execute()) return true;

        return false;
    }

    // search ville
    function search($keywords){

        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE nom_ville = ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        //$keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "{$keywords}";

        // bind
        $stmt->bindParam(1, $keywords);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
?>