

<?php
session_start();
//Template
ob_start();

//APPEL DES CONTROLLERS
require_once "../controllers/users/users_controller.php";
require_once "../controllers/products/products_controller.php";
require_once "../controllers/categories/categories_controller.php";
require_once  "../controllers/administration/admin_controller.php";


$url = "";
//Recuperer URL du navigateur avec la Super Globale $_GET
if(isset($_GET["url"])){
    $url = $_GET["url"];
}else{
    $url == "connexion";
}



//ROUTES
/*----------------------------------------USERS------------------------------------------*/
if($url === "connexion"){
    $title = "Mic-Office : Connexion";
    LoginUsersController();
    LoginAsAdminController();
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
}elseif ($url === "deconnexion" && ($_SESSION["is_login"] || $_SESSION["is_admin"])){
    require_once "users/logout.php";
    /*----------------------------------------PRODUITS------------------------------------------*/
}elseif ($url === "liste-produits" && $_SESSION["is_login"]){
    $title = "Mic-Office : Vos produits";
    require_once "products/products_list.php";
}elseif ($url === "liste-produits-utilisateur" && $_SESSION["is_login"]){
    $title = "Mic-Office : Gestion de vos produit";
    require_once "products_user/products_user_list.php";
}elseif ($url === "ajouter-produit" && $_SESSION["is_login"]){
    $title = "Mic-Office : Ajouter un produit";
    require_once "products_user/add_product.php";
    AddProductController();
}elseif ($url === "detail-product-user" && $_SESSION["is_login"]){
    $title = "Mic-Office : Détails du produit";
    require_once "products_user/details_user_produit.php";
}elseif ($url === "supprimer-produits" && $_SESSION["is_login"]){
    DeleteUserProductWithImagesController();
}elseif ($url == "editer-produits" && $_SESSION["is_login"]){
    $title = "Mic-Office : Editer votre produit";
    require_once "products_user/edit_user_product.php";
    EditUserProductController();
}
/*------------------------------ADMINISTRATION---------------------------------------*/
elseif ($url === "administration" && $_SESSION["is_admin"]){
    $title = "Mic-Office : ADMINISTRATION";
    require_once "administration/admin_home.php";
}elseif ($url === "utilisateurs" && $_SESSION["is_admin"]){
    $title = "Mic-Office : Tous les utilisateurs";
    DisplayAllUsersController();
}elseif ($url === "supprimer-utilisateur" && $_SESSION["is_admin"]){
    DeleteOneUserController();
}elseif ($url == "catégories" && $_SESSION["is_admin"]){
    $title = "Mic-Office : Catégories";
    DisplayAllCategoriesController();
}elseif ($url === "supprimer-categorie" && $_SESSION["is_admin"]){
    DeleteOneCategoryController();
}elseif ($url === "ajouter-categorie" && $_SESSION["is_admin"]){
    AddCategoryController();
}elseif ($url === "admin-images" && $_SESSION["is_admin"]){
    $title = "Mic-Office : Liste des images";
    DisplayAllImagesController();
}elseif ($url === "supprimer-image" && $_SESSION["is_admin"]){
    ?>
        <script>
            alert("Vous avez besoin de l'autorisation de l'utilisateur pour supprimer une image !");
            window.location = "admin-images";
        </script>
    <?php

}elseif ($url === "admin-produits" && $_SESSION["is_admin"]){
    $title = "Mic-Office : Liste de tous les produits";
    DisplayAllProductsController();
}elseif ($url === "supprimer-un-produit" && $_SESSION["is_admin"]){
    DeleteUserProductWithImagesController();
    header("Location: admin-produits");
}
//On effectue une redirection si url ne correspond a aucune route via des regexs
elseif($url !=  '#:@&-[\w]+)#'){
    //On redirige vers la page d'accueil
    header("Location: connexion");
}


//Template
$content = ob_get_clean();
require_once "template.php";