<?php
require_once "../models/database.php";

class Administration
{
    //USERS
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getPDOInstance()->GetPDOConnexion();
    }

    //Lister les utilisateurs
    public function ListAllUsers(){
        $sql = "SELECT * FROM users";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $users = $statement->fetchAll();
        return $users;
    }
    //Supprimer un utilisateur
    public function DeleteOneUser(){
        $sql = "DELETE FROM users WHERE id = ?";
        $statement = $this->db->prepare($sql);
        $user_id = $_GET["id"];
        $statement->bindParam(1, $user_id);
        $delete_user = $statement->execute([$user_id]);
        return $delete_user;
    }

}