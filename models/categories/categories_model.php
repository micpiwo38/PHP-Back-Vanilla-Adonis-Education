<?php
require_once "../models/database.php";

class Categorie_model
{
    private PDO $db;

    //Connexion a l'aide du singleton
    public function __construct()
    {
        $this->db = Database::getPDOInstance()->GetPDOConnexion();
    }

    public function DisplayCategories(){
        $sql = "SELECT * FROM categories";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $categories = $statement->fetchAll();
        return $categories;
    }

}