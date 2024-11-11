<?php
require_once "../models/database.php";
require_once "../services/upload_multiple_files.php";

class Products_model
{

    private $product_id;
    private $product_name;
    private $product_description;
    private $product_price;
    private $product_category;
    private $product_images;
    private $product_stock;
    private $product_owner;

    private PDO $db;

    //Connexion a l'aide du singleton
    public function __construct()
    {
        $this->db = Database::getPDOInstance()->GetPDOConnexion();
    }

    //Afficher les produits de tous les utilisateurs inscrit
    public function DisplayAllProducts(){
        $sql = "SELECT 
                    *
                    FROM products
                    LEFT JOIN users ON products.product_owner = users.id
                    LEFT JOIN categories ON products.product_category = categories.category_id
                    LEFT JOIN images ON products.product_id = images.id_product
                ";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $products = $statement->fetchAll();

        return $products;
    }

    //Les images par produits
    public function DisplayImageByProduct($product_id){

        $sql = "SELECT * FROM images  WHERE images.id_product = ?";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(1, $product_id);
        $statement->execute();
        return $statement->fetchAll();
    }

    //Afficher les produits par propriétaires
    public function DisplayProductsByOwner(){
        $sql = "SELECT *
                    FROM products
                    LEFT JOIN users ON products.product_owner = users.id
                    LEFT JOIN categories ON products.product_category = categories.category_id
                    LEFT JOIN images ON products.product_id = images.id_product 
                    WHERE products.product_owner = ?
                ";
        $this->product_owner = $_SESSION["user_id"];
        $statement = $this->db->prepare($sql);
        $statement->bindParam(1, $this->product_owner);
        $statement->execute();
        $product_by_user = $statement->fetchAll();
        return $product_by_user;
    }

    //Afficher les details d'une annonce

    //Ajouter une annonce
    public function AddProduct(
            string $product_name,
            string $product_description,
            float $product_price,
            int $product_category,
            int $product_stock,
            int $product_owner,
            array $images){
        //Champ du formulaire
        $this->product_name = $product_name;
        $this->product_description = $product_description;
        $this->product_price = $product_price;
        $this->product_category = $product_category;
        $this->product_stock = $product_stock;
        $this->product_images = $images;
        $_SESSION["user_id"] = $product_owner;
        $this->product_owner = $product_owner;

        //La requète
        $sql = "INSERT INTO products (product_name, product_description, product_price, product_category, product_stock, product_owner)
                VALUES (?,?,?,?,?,?)";
        $statement = $this->db->prepare($sql);
        $statement->execute([
            $this->product_name,
            $this->product_description,
            $this->product_price,
            $this->product_category,
            $this->product_stock,
            $this->product_owner,
        ]);
        //Recuperer l'ID du dernier produit ajouter = fonction native de PDO
        $this->product_id = $this->db->lastInsertId();
        //Upload des images et insertion dans la table images
        $images_services = new Upload_multiple_files();
        $images_services->updload_multiple_images($this->product_id, $this->product_images);
        return $this->product_id;

    }

}