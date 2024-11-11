<?php
require_once "../models/database.php";

class Upload_multiple_files
{

    private PDO $db;

    //Connexion a l'aide du singleton
    public function __construct()
    {
        $this->db = Database::getPDOInstance()->GetPDOConnexion();
    }

    //Sauver les images dans sa table
    public function SaveImageToDatabase($images_name, $id_product){
        $sql = "INSERT INTO images (id_product, images_name) VALUES (?,?)";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(1, $images_name);
        $statement->bindParam(2, $id_product);
        $statement->execute([
            $images_name,
            $id_product
        ]);
    }
    //Upmoader des images pour 1 produits
    public function updload_multiple_images($product_id,$images){
        $upload_directory = "../src/images/";
        //Check le dossier existe
        if(!is_dir($upload_directory)){
            var_dump("le dossier n'existe pas");
        }
        //Parcours des images a upload
        foreach ($images["name"] as $key => $image_name){
            $tmp_name = $images["tmp_name"][$key];
            //Le nom de l'image
            $image_name = basename($image_name);
            //Destination
            $target_path = $upload_directory . $image_name;
            //Deplacer le fichier => nom temporaire, destination
            if(move_uploaded_file($tmp_name, $target_path)){
                //Enregister en appelant la methode Save
                $this->SaveImageToDatabase($product_id, $image_name);
                echo "<div class='alert alert-success p-3'>Vos images ont été téléchargées</div>";
            }else{
                echo "<div class='alert alert-danger p-3'>Erreur lors du chargement de vos images !</div>";
            }
        }
    }

}