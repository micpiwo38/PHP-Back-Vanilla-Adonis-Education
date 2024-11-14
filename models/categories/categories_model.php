<?php
require_once "../models/database.php";

class Categorie_model
{
    private PDO $db;
    private $category_name;

    //Connexion a l'aide du singleton
    public function __construct()
    {
        $this->db = Database::getPDOInstance()->GetPDOConnexion();
    }
    //Lister les catégories
    public function DisplayCategories(){
        $sql = "SELECT * FROM categories";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $categories = $statement->fetchAll();
        return $categories;
    }

    //Supprimer une catégorie
    public function DeleteOneCategory(){
        $sql = "DELETE FROM categories WHERE category_id = ?";
        $statement = $this->db->prepare($sql);
        $category_id = $_GET["id"];
        $statement->bindParam(1, $category_id);
        $delete_category = $statement->execute([$category_id]);
        return $delete_category;
    }

    //Ajouter une catégorie
    public function AddCategory(){
        $this->category_name = trim(htmlspecialchars($_POST["category_name"]));

        $sql = "INSERT INTO categories(category_name) VALUES (?)";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(1, $this->category_name);
        $add_category = $statement->execute([$this->category_name]);
        return $add_category;
    }



}