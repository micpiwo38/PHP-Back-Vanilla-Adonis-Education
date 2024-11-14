<?php
require_once "../models/categories/categories_model.php";

//Afficher les catégories
function DisplayCategoriesController(){
    $categories_model = new Categorie_model();
    $categories = $categories_model->DisplayCategories();

    return $categories;
}

//Supprimer une catégorie
function DeleteOneCategoryController(){
    $categories_model = new Categorie_model();
    $delete_category = true;
    if($delete_category){
        ?>
        <script>
            confirm("Valider la suppression de cette catégorie ?")
        </script>
        <?php
        $categories_model->DeleteOneCategory();
        header("Location: catégories");
    }else{
        echo "Erreur lors de la suppression du cette catégorie !";
    }
}



