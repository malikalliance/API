<?php
class Client{

    // database connection and table name
    private $conn;
    private $table_name = "client";

    // object properties
    public $id;
    public $enseigne;
    public $url_becom;
    public $type_site;
    public $mois_signature;
    public $annee_signature;
    public $civilite;
    public $nom_gerant;
    public $prenom_gerant;
    public $email;
    public $adresse;
    public $ville;
    public $cp;
    public $tel;
    public $interlocuteur_nom;
    public $interlocuteur_prenom;

    public function __construct($db){
        $this->conn = $db;
    }

    // used by select drop-down list
    public function read(){
        //select all data
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id ASC";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }

    public function generer(){
        //select all data
        $query = "SELECT distinct c.id, c.enseigne, c.url_becom, a.activite, a.id as id_activite, v.nom_ville, 
                  v.id as id_ville FROM ville v, clientville cv, clientactivite ca, client c, activite a
                  WHERE v.id=cv.id_ville AND cv.id_client=c.id and a.id=ca.id_activite and ca.id_client=c.id
                  ORDER BY c.enseigne, a.activite";

        $stmt = $this->conn->prepare( $query );
        $stmt->execute();

        return $stmt;
    }

    // create client
    function create(){

        // query to insert record
        $query = "INSERT INTO " . $this->table_name . " SET enseigne=:enseigne, url_becom=:url_becom, 
                mois_signature=:mois_signature, annee_signature=:annee_signature, civilite=:civilite,
                nom_gerant=:nom_gerant, prenom_gerant=:prenom_gerant, email=:email, adresse=:adresse, 
                ville=:ville, cp=:cp, tel=:tel, interlocuteur_nom=:interlocuteur_nom,
                interlocuteur_prenom=:interlocuteur_prenom, type_site=:type_site";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->enseigne=htmlspecialchars(strip_tags($this->enseigne));
        $this->url_becom=htmlspecialchars(strip_tags($this->url_becom));
        $this->mois_signature=htmlspecialchars(strip_tags($this->mois_signature));
        $this->annee_signature=htmlspecialchars(strip_tags($this->annee_signature));
        $this->civilite=htmlspecialchars(strip_tags($this->civilite));
        $this->nom_gerant=htmlspecialchars(strip_tags($this->nom_gerant));
        $this->prenom_gerant=htmlspecialchars(strip_tags($this->prenom_gerant));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->adresse=htmlspecialchars(strip_tags($this->adresse));
        $this->ville=htmlspecialchars(strip_tags($this->ville));
        $this->cp=htmlspecialchars(strip_tags($this->cp));
        $this->tel=htmlspecialchars(strip_tags($this->tel));
        $this->interlocuteur_nom=htmlspecialchars(strip_tags($this->interlocuteur_nom));
        $this->interlocuteur_prenom=htmlspecialchars(strip_tags($this->interlocuteur_prenom));
        $this->type_site=htmlspecialchars(strip_tags($this->type_site));

        // bind values
        $stmt->bindParam(":enseigne", $this->enseigne);
        $stmt->bindParam(":url_becom", $this->url_becom);
        $stmt->bindParam(":mois_signature", $this->mois_signature);
        $stmt->bindParam(":annee_signature", $this->annee_signature);
        $stmt->bindParam(":civilite", $this->civilite);
        $stmt->bindParam(":nom_gerant", $this->nom_gerant);
        $stmt->bindParam(":prenom_gerant", $this->prenom_gerant);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":adresse", $this->adresse);
        $stmt->bindParam(":ville", $this->ville);
        $stmt->bindParam(":cp", $this->cp);
        $stmt->bindParam(":tel", $this->tel);
        $stmt->bindParam(":interlocuteur_nom", $this->interlocuteur_nom);
        $stmt->bindParam(":interlocuteur_prenom", $this->interlocuteur_prenom);
        $stmt->bindParam(":type_site", $this->type_site);

        // execute query
        if($stmt->execute()) return true;

        return false;
    }

    // read just one client
    function readOne(){

        // query to read single record
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";

        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind id of client to be updated
        $stmt->bindParam(1, $this->id);

        // execute query
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->enseigne=$row['enseigne'];
        $this->url_becom=$row['url_becom'];
        $this->mois_signature=$row['mois_signature'];
        $this->annee_signature=$row['annee_signature'];
        $this->civilite=$row['civilite'];
        $this->nom_gerant=$row['nom_gerant'];
        $this->prenom_gerant=$row['prenom_gerant'];
        $this->email=$row['email'];
        $this->adresse=$row['adresse'];
        $this->ville=$row['ville'];
        $this->cp=$row['cp'];
        $this->tel=$row['tel'];
        $this->interlocuteur_nom=$row['interlocuteur_nom'];
        $this->interlocuteur_prenom=$row['interlocuteur_prenom'];
        $this->type_site=$row['type_site'];
    }

    // update the client
    function update(){

        // update query
        $query = "UPDATE " . $this->table_name . " SET enseigne=:enseigne, url_becom=:url_becom, 
                mois_signature=:mois_signature, annee_signature=:annee_signature, civilite=:civilite,
                nom_gerant=:nom_gerant, prenom_gerant=:prenom_gerant, email=:email, adresse=:adresse,
                ville=:ville, cp=:cp, tel=:tel,interlocuteur_nom=:interlocuteur_nom, 
                interlocuteur_prenom=:interlocuteur_prenom, type_site=:type_site
            WHERE
                id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->id=htmlspecialchars(strip_tags($this->id));
        $this->enseigne=htmlspecialchars(strip_tags($this->enseigne));
        $this->url_becom=htmlspecialchars(strip_tags($this->url_becom));
        $this->mois_signature=htmlspecialchars(strip_tags($this->mois_signature));
        $this->annee_signature=htmlspecialchars(strip_tags($this->annee_signature));
        $this->civilite=htmlspecialchars(strip_tags($this->civilite));
        $this->nom_gerant=htmlspecialchars(strip_tags($this->nom_gerant));
        $this->prenom_gerant=htmlspecialchars(strip_tags($this->prenom_gerant));
        $this->email=htmlspecialchars(strip_tags($this->email));
        $this->adresse=htmlspecialchars(strip_tags($this->adresse));
        $this->ville=htmlspecialchars(strip_tags($this->ville));
        $this->cp=htmlspecialchars(strip_tags($this->cp));
        $this->tel=htmlspecialchars(strip_tags($this->tel));
        $this->interlocuteur_nom=htmlspecialchars(strip_tags($this->interlocuteur_nom));
        $this->interlocuteur_prenom=htmlspecialchars(strip_tags($this->interlocuteur_prenom));
        $this->type_site=htmlspecialchars(strip_tags($this->type_site));

        // bind values
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(":enseigne", $this->enseigne);
        $stmt->bindParam(":url_becom", $this->url_becom);
        $stmt->bindParam(":mois_signature", $this->mois_signature);
        $stmt->bindParam(":annee_signature", $this->annee_signature);
        $stmt->bindParam(":civilite", $this->civilite);
        $stmt->bindParam(":nom_gerant", $this->nom_gerant);
        $stmt->bindParam(":prenom_gerant", $this->prenom_gerant);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":adresse", $this->adresse);
        $stmt->bindParam(":ville", $this->ville);
        $stmt->bindParam(":cp", $this->cp);
        $stmt->bindParam(":tel", $this->tel);
        $stmt->bindParam(":interlocuteur_nom", $this->interlocuteur_nom);
        $stmt->bindParam(":interlocuteur_prenom", $this->interlocuteur_prenom);
        $stmt->bindParam(":type_site", $this->type_site);

        // execute the query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // delete the client
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

    // search products
    function search($keywords){

        // select all query
        $query = "SELECT * FROM " . $this->table_name . " WHERE 
                  url_becom LIKE ?";

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