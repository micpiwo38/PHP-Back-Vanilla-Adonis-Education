

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

if($url === "connexion"){
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
}elseif ($url === "update_user_message"){
    $title = "Mic-Office : Modification mot de passe";
    require_once "users/update_user_message.php";
    UpdateUserController();
}elseif ($url === "change_password"){
    $title = "Mic-Office : Entrer nouveau mot de passe";
    require_once "users/change_password.php";
    ValidateNewPasswordController();

}elseif ($url === "deconnexion" && $_SESSION["is_login"]){

    require_once "users/logout.php";
}//On effectue une redirection si url ne correspond a aucune route via des regexs

 elseif($url !=  '#:@&-[\w]+)#'){
    //On redirige vers la page d'accueil
    header("Location: connexion");
}


//Template
$content = ob_get_clean();
require_once "template.php";