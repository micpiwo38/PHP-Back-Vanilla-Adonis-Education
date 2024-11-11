<?php
require_once "../models/categories/categories_model.php";


function DisplayCategoriesController(){
    $categories_model = new Categorie_model();
    $categories = $categories_model->DisplayCategories();

    return $categories;
}