<?php
require_once "../models/database.php";

class Images_model
{
    private PDO $db;

    //Connexion a l'aide du singleton
    public function __construct()
    {
        $this->db = Database::getPDOInstance()->GetPDOConnexion();
    }

    public function DisplayAllImages(){
        $sql = "SELECT * FROM images INNER JOIN products ON images.id_product = products.product_id";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $images = $statement->fetchAll();

        return $images;

    }

}