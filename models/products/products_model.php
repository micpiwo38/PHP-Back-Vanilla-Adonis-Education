<?php
require_once "../models/database.php";

class Products_model extends Database
{

    private $product_id;
    private $product_name;
    private $product_description;
    private $product_price;
    private $product_category;
    private $product_images;
    private $product_stock;
    private $product_owner;

    //Afficher les produits de tous les utilisateurs inscrit
    public function DisplayAllProducts(){
        $db = $this->GetPDOConnexion();
        $sql = "SELECT 
                    *
                    FROM products
                    LEFT JOIN users ON products.product_owner = users.id
                    LEFT JOIN categories ON products.product_category = categories.category_id
                    LEFT JOIN images ON products.product_id = images.id_product
                ";
        $statement = $db->prepare($sql);
        $statement->execute();
        $products = $statement->fetchAll();

        return $products;
    }

    //Les images par produits
    public function DisplayImageByProduct($product_id){
        $db = $this->GetPDOConnexion();
        $sql = "SELECT * FROM images  WHERE images.id_product = ?";
        $statement = $db->prepare($sql);
        $statement->bindParam(1, $product_id);
        $statement->execute();
        return $statement->fetchAll();
    }

    //Afficher les produits par propriétaires
    public function DisplayProductsByOwner(){

    }

}