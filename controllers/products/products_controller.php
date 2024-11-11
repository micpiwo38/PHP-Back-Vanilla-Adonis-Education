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
