<?php

class Database{

    //Vars private
    private $db_host = "localhost";
    private $db_name = "mic_office";
    private $db_user = "root";
    private $db_password = "";

    private $is_connected = false;

   public function GetPDOConnexion() : PDO {
        if(!$this->is_connected){
            $db = new PDO("mysql:host=" .$this->db_host. ";dbname=" .$this->db_name. ";charset=utf8", $this->db_user, $this->db_password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo '<div class="container mt-3 w-50  alert alert-success p-3">Vous êtes connecter a la base de données via PDO MySQL !</div>';
            return $db;
        }else{
            echo '<div class="container mt-3 w-50 alert alert-danger p-3">Erreur de connexion a la base de données PDO MySQL</div>';
            die();
        }
   }
}