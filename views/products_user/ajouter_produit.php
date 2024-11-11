<div class="container-fluid">
    <?php require_once "./navbar.php"?>
</div>
    <div class="container shadow rounded p-3 mt-3">
    <?php
    echo "Bienvenue : " .$_SESSION["email"];
    $categories = DisplayCategoriesController();
    ?>
        <h1 class="text-success">Ajouter un produit</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="mt-3">
                <label for="name">Nom du produit</label>
                <input type="text" id="name" name="product_name" class="form-control" placeholder="nom du produit"/>
            </div>
            <div class="mt-3">
                <label for="desc">Description du produit</label>
                <textarea type="text" id="desc" name="product_description" class="form-control"></textarea>
            </div>
            <div class="mt-3">
                <label for="price">Prix du produit</label>
                <input type="number" step="0.01" id="price" name="product_price" class="form-control" placeholder="prix du produit en €"/>
            </div>

            <div class="mt-3">
                <label for="price">Catégorie du produit</label>
                <select name="product_category" class="custom-select">
                    <option selected>Choix de la catégorie</option>
                    <?php
                        foreach ($categories as $category){
                            ?>
                            <option value="<?= $category["category_id"] ?>"><?= $category["category_name"] ?></option>
                            <?php
                        }
                    ?>
                </select>
            </div>

            <div class="mt-3">
                <label for="stock">Nombre de produit en stock</label>
                <input type="number" id="price" name="product_stock" class="form-control" placeholder="50"/>
            </div>

            <div class="mt-3">
                <label for="images" class="form-label">Image du produit</label>
                <hr>
                <em class="text-success">Vous pouvez ajouter plusieurs photo en maintenant la touche Ctrl Gauche (Pomme Gauche sur Mac)</em>
                <hr>
                <input type="file" id="images" name="images_name[]" class="form-control" multiple />
            </div>

            <div class="mt-3">
                <button class="btn btn-success" name="btn-add-product">Ajouter le produits</button>
            </div>
        </form>
</div>
