

<?php
//Template
ob_start();

//APPEL DES CONTROLLERS
require_once "../controllers/users/users_controller.php";

//Recuperer URL du navigateur avec la Super Globale $_GET
if(isset($_GET["url"])){
    $url = $_GET["url"];
}else{
    $url == "connexion";
}



//ROUTES

if($url === ""){
    header("Location: connexion");
}elseif($url === "connexion"){
    $title = "Mic-Office : Connexion";
    require_once "users/login.php";
}elseif($url === "inscription"){
    $title = "Mic-Office : Inscription";
    require_once "users/register.php";
    RegisterUsersController();
}

//Template
$content = ob_get_clean();
require_once "template.php";