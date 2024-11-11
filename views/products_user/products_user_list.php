<div class="container-fluid">
    <?php require_once "./navbar.php"?>
</div>
<div class="container shadow rounded p-3 mt-3">
    <?php
    echo "Bienvenue : " .$_SESSION["email"];
    $products_by_user = DisplayProductByUserController();
    ?>
    <a href="ajouter-produit" class="btn btn-info mt-3">Ajouter un produit</a>
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
            <th scope="col">Action</th>

        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($products_by_user as $product){
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
                        <a href="#" class="btn btn-warning">Détails</a>
                    </td>
                </tr>
                <?php
            }
        ?>


        </tbody>
    </table>

</div>