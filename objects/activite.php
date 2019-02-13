<?php
class Activite{

    // database connection and table name
    private $conn;
    private $table_name = "activite";

    // object properties
    public $id;
    public $activite;

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

    // create activite
    function create(){

        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET activite=:activite";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->activite=htmlspecialchars(strip_tags($this->activite));

        // bind values
        $stmt->bindParam(":activite", $this->activite);

        // execute query
        if($stmt->execute()) return true;

        return false;
    }

    // used when filling up the update activite form
    function readOne(){
        // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of activite to be updated
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->activite=$row['activite'];
    }

    // update the activite
    function update(){

        // update query
        $query = "UPDATE " . $this->table_name . " SET
                activite=:activite
            WHERE
                id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->activite=htmlspecialchars(strip_tags($this->activite));

        // bind values
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(":activite", $this->activite);

        // execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // delete the activite
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

    // search activite
    function search($keywords){

        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE activite = ?";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "{$keywords}";

        // bind
        $stmt->bindParam(1, $keywords);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
?>