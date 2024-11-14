<?php
//Modeles
require_once "../models/administration/administration.php";
require_once "../models/images/images_model.php";
require_once "../models/products/products_model.php";

//Autres controller
require_once "../controllers/categories/categories_controller.php";
require_once "../controllers/products/products_controller.php";

//Afficher tous les utilisateur
function DisplayAllUsersController(){
    $admin_model = new Administration();
    $users = $admin_model->ListAllUsers();
    require_once "../views/navbar.php";
    //TEMPLATE
    ?>
    <div class="container shadow rounded mt-3">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="utilisateurs">UTILISATEURS</a>
                    </li>
                    <li class="list-group-item">
                        <a href="admin-produits">PRODUITS</a>
                    </li>
                    <li class="list-group-item">
                        <a href="catégories">CATÉGORIES</a>
                    </li>
                    <li class="list-group-item">
                        <a href="admin-images">IMAGES</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9 col-sm-12">
                <div>UTILISATEURS :</div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Email</th>
                        <th scope="col">ACTIONS</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($users as $user){
                            ?>
                            <tr>
                                <th scope="row"><?= $user["id"] ?></th>
                                <td><?= $user["email"] ?></td>
                                <td>
                                    <a class="btn btn-danger" href="supprimer-utilisateur?id=<?= $user["id"] ?>">Supprimer</a>
                                </td>
                            </tr>
                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
}

//Supprimer un utilisateur
function DeleteOneUserController(){
    $admin_model = new Administration();
    $delete_user = true;
    if($delete_user){
        ?>
            <script>
                confirm("Valider la suppression de cet utilisateur ?")
            </script>
        <?php
        $admin_model->DeleteOneUser();
        header("Location: utilisateurs");
    }else{
        echo "Erreur lors de la suppression du cet utilisateur !";
    }
}


//Afficher toutes les catégories
function DisplayAllCategoriesController(){
    $categories = DisplayCategoriesController();
    require_once "../views/navbar.php";
    //TEMPLATE
    ?>
    <div class="container shadow rounded mt-3">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="utilisateurs">UTILISATEURS</a>
                    </li>
                    <li class="list-group-item">
                        <a href="admin-produits">PRODUITS</a>
                    </li>
                    <li class="list-group-item">
                        <a href="catégories">CATÉGORIES</a>
                    </li>
                    <li class="list-group-item">
                        <a href="admin-images">IMAGES</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9 col-sm-12">
                <div>CATÉGORIES :
                    <form method="post">
                        <div class="mt-3">
                            <label for="cat_name">Nom de la catégorie</label>
                            <input id="cat_name" type="text" name="category_name" class="form-control" />
                        </div>
                        <div class="mt-3">
                            <button name="btn-add-category" href="ajouter-categorie" class="btn btn-info">Ajouter la catégorie</button>
                        </div>
                        <?php
                            if(isset($_POST["btn-add-category"])){
                                AddCategoryController();
                            }
                        ?>
                    </form>
                </div>
                <table class="table table-striped mt-3">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Catégories</th>
                        <th scope="col">ACTIONS</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($categories as $category){
                        ?>
                        <tr>
                            <th scope="row"><?= $category["category_id"] ?></th>
                            <td><?= $category["category_name"] ?></td>
                            <td>
                                <a class="btn btn-danger" href="supprimer-categorie?id=<?= $category["category_id"] ?>">X</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
}

//Ajouter une catégorie
function AddCategoryController(){
    $category_model = new Categorie_model();
    $add_category = $category_model->AddCategory();
    if($add_category){
        header("Location: catégories");
    }else{
        echo "Erreur lors de l'ajout de la catégories !";
    }
}

//Afficher toutes les photos
function DisplayAllImagesController(){
    $images_model = new Images_model();
    $images = $images_model->DisplayAllImages();
    require_once "../views/navbar.php";
    //TEMPLATE
    ?>
    <div class="container shadow rounded mt-3">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="utilisateurs">UTILISATEURS</a>
                    </li>
                    <li class="list-group-item">
                        <a href="admin-produits">PRODUITS</a>
                    </li>
                    <li class="list-group-item">
                        <a href="catégories">CATÉGORIES</a>
                    </li>
                    <li class="list-group-item">
                        <a href="admin-images">IMAGES</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9 col-sm-12">
                <div>IMAGES :</div>
                <table class="table table-striped mt-3">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Produit</th>
                        <th scope="col">ACTIONS</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($images as $image){
                        ?>
                        <tr>
                            <th scope="row"><?= $image["image_id"] ?></th>
                            <td>
                                <img width="50%" class="img-fluid" src="./src/images/<?= $image["images_name"] ?>" title="" alt="" />
                            </td>
                            <td>
                                Produit : <?= $image["id_product"] ?>
                            </td>
                            <td>
                                <a class="btn btn-danger" href="supprimer-image">X</a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
}



//Afficher tous les produits
function DisplayAllProductsController(){

    $products = DisplayAllProductsWithImagesController();

    require_once "../views/navbar.php";
    //TEMPLATE
    ?>
    <div class="container shadow rounded mt-3">
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <ul class="list-group">
                    <li class="list-group-item">
                        <a href="utilisateurs">UTILISATEURS</a>
                    </li>
                    <li class="list-group-item">
                        <a href="admin-produits">PRODUITS</a>
                    </li>
                    <li class="list-group-item">
                        <a href="catégories">CATÉGORIES</a>
                    </li>
                    <li class="list-group-item">
                        <a href="admin-images">IMAGES</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-9 col-sm-12">
                <div>LISTE DES PRODUITS DE TOUS LES UTILISATEURS :</div>
                <table class="table table-striped mt-3">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nom</th>
                        <th scope="col">Image(s)</th>
                        <th scope="col">Description</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Catégorie</th>
                        <th scope="col">Stock</th>
                        <th scope="col">ACTION</th>

                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($products as $product){
                        ?>
                        <tr>
                            <th scope="row"><?= $product["product_id"]  ?></th>
                            <td><?= $product["product_name"]  ?></td>
                            <td>
                                <div id="carouselProduct<?= $product["product_id"] ?>" class="carousel slide">
                                    <div class="carousel-inner">
                                        <?php foreach ($product['images'] as $index => $image): ?>
                                            <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                                <img width="100%" src="./src/images/<?= $image["images_name"]  ?>" alt="<?= $product["product_name"] ?>" title="<?= $product["product_name"] ?>"/>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <!-- Contrôles du carrousel -->
                                    <a class="carousel-control-prev" type="button" data-bs-target="#carouselProduct<?= $product['product_id'] ?>" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" type="button" data-bs-target="#carouselProduct<?= $product['product_id'] ?>" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>
                            </td>

                            <td><?= $product["product_description"]  ?></td>
                            <td><?= $product["product_price"]  ?></td>
                            <td><?= $product["product_category"]  ?></td>
                            <td><?= $product["product_stock"]  ?></td>
                            <td>
                                <a class="btn btn-danger" href="supprimer-un-produit?id=<?= $product["product_id"] ?>">X</a>
                            </td>

                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php
}









