<?php

class Database{

    //Vars private
    private $db_host = "localhost";
    private $db_name = "mic_office";
    private $db_user = "root";
    private $db_password = "";

    private static $pdo_insatnce = null;
    private PDO|bool $connection = false;

    //Constructeur => eviter une insatnce directe et la copie de l'objet
    private function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=" .$this->db_host. ";dbname=" .$this->db_name. ";charset=utf8", $this->db_user, $this->db_password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo '<div class="container mt-3 w-50  alert alert-success p-3">Vous êtes connecter a la base de données via PDO MySQL !</div>';
        }catch (PDOException $e){
            echo '<div class="container mt-3 w-50 alert alert-danger p-3">Erreur de connexion a la base de données PDO MySQL</div>';
            die();
        }
    }

    //Methode statique pour recuperer une insatnce unique de la connexion
    public static function getPDOInstance(): Database{
        if(self::$pdo_insatnce == null){
            self::$pdo_insatnce = new Database();
        }
        return self::$pdo_insatnce;
    }
    //Recuperer la connexion => une seule fois
    public function GetPDOConnexion(){
        return $this->connection;
    }
    //Eviter un clone de l'instance
    private function __clone(){}
    //Eveiter le deserialisation de m'insatnce
    public function __wakeup() {}
}