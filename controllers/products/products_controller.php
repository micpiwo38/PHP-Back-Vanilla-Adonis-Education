<?php
require_once "../models/products/products_model.php";

//Afficher tous les produits de tous les utilisateur
function DisplayAllProductsWithImagesController()
{
    $product_model = new Products_model();
    $products_data = $product_model->DisplayAllProducts();
    //Tableau d'images
    $products_with_images = [];

    foreach ($products_data as $product){
        $product_id = $product["product_id"];
        //Ajouter le produit au tableau d'image
        if(!isset($products_with_images[$product_id])){
            $products_with_images[$product_id] = [
                "product_id" => $product["product_id"],
                "product_name" => $product["product_name"],
                "product_description" => $product["product_description"],
                "product_price" => $product["product_price"],
                "product_category" => $product["category_name"],
                "product_stock" => $product["product_stock"],
                "product_owner" => $product["email"],
                "images" => []
            ];
        }
        $product_images = $product_model->DisplayImageByProduct($product_id);

        foreach ($product_images as $image){
            $products_with_images[$product_id]["images"][] = [
                "image_id" => $image["image_id"],
                'images_name' => $image["images_name"]
            ];
        }
    }
    return array_values($products_with_images);
}

//Afficher le produits par utilisateur
function DisplayProductByUserController(){
    $product_model = new Products_model();
    $products_data = $product_model->DisplayProductsByOwner();
    //Tableau d'images
    $products_with_images = [];

    foreach ($products_data as $product){
        $product_id = $product["product_id"];
        //Ajouter le produit au tableau d'image
        if(!isset($products_with_images[$product_id])){
            $products_with_images[$product_id] = [
                "product_id" => $product["product_id"],
                "product_name" => $product["product_name"],
                "product_description" => $product["product_description"],
                "product_price" => $product["product_price"],
                "product_category" => $product["category_name"],
                "product_stock" => $product["product_stock"],
                "product_owner" => $product["email"],
                "images" => []
            ];
        }
        $product_images = $product_model->DisplayImageByProduct($product_id);

        foreach ($product_images as $image){
            $products_with_images[$product_id]["images"][] = [
                "image_id" => $image["image_id"],
                'images_name' => $image["images_name"]
            ];
        }
    }
    return array_values($products_with_images);
}

//Ajouter un produit + multiple images
function AddProductController(){
    $product_model = new Products_model();
    if(isset($_POST["btn-add-product"])){
        //Champ du formulaire
        $product_name = trim(htmlspecialchars($_POST["product_name"]));
        $product_description = trim(htmlspecialchars($_POST["product_description"]));
        $product_price = trim(htmlspecialchars($_POST["product_price"]));
        $product_category = trim(htmlspecialchars($_POST["product_category"]));
        $product_stock = trim(htmlspecialchars($_POST["product_stock"]));
        $product_owner = $_SESSION["user_id"];

        //Les images
        $images = $_FILES["images_name"];
        $product_id = $product_model->AddProduct(
            $product_name,
            $product_description,
            $product_price,
            $product_category,
            $product_stock,
            $product_owner,
            $images
        );


        if($product_id){
            echo "<div class='alert alert-success p-3'>Votre produit a été ajouté avce succès !
                    <a href='liste-produits-utilisateur' class='btn btn-success mt-3'>Voir mes produits</a>
                </div>";
        }else{
            echo "<div class='alert alert-danger p-3'>Erreur lors de l'ajout de votre produit !</div>";
        }
    }

}
