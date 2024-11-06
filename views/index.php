

<?php
session_start();
//Template
ob_start();

//APPEL DES CONTROLLERS
require_once "../controllers/users/users_controller.php";

$url = "";
//Recuperer URL du navigateur avec la Super Globale $_GET
if(isset($_GET["url"])){
    $url = $_GET["url"];
}else{
    $url == "connexion";
}

//ROUTES

if($url === "" && !$_SESSION["is_login"]){
    header("Location: connexion");
}elseif($url === "connexion"){
    $title = "Mic-Office : Connexion";
    LoginUsersController();
    require_once "users/login.php";
}elseif($url === "inscription"){
    $title = "Mic-Office : Inscription";
    require_once "users/register.php";
    RegisterUsersController();
}elseif ($url === "profile" && $_SESSION["is_login"]){
    $title = "Mic-Office : Profile";
    require_once "users/profile.php";
    DeleteUserController();
}elseif ($url === "delete_user_message" && $_SESSION["is_login"]){
    $title = "Mic-Office : Compte Supprimer";
    require_once "users/delete_user_message.php";
}elseif ($url === "deconnexion" && $_SESSION["is_login"]){

    require_once "users/logout.php";
}

//Template
$content = ob_get_clean();
require_once "template.php";