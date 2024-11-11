<div class="container-fluid">
    <?php require_once "./navbar.php"?>
</div>
<div class="container shadow rounded p-3 mt-3">
    <?php
    echo "Bienvenue : " .$_SESSION["email"];
    $productsWithImages = DisplayAllProductsWithImagesController();
    ?>
    <div class="row">
        <?php foreach ($productsWithImages as $product): ?>
            <div class="col-md-3 col-mx-12 mx-3">
                <div class="card" style="width: 18rem;">
                    <!-- Carrousel Bootstrap -->
                    <div id="carouselProduct<?= $product["product_id"] ?>" class="carousel slide">
                        <div class="carousel-inner">
                            <?php foreach ($product['images'] as $index => $image): ?>
                                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                                    <img class="d-block w-100" src="./src/images/<?= ($image["images_name"]) ?>" alt="<?= $product["product_name"] ?>" title="<?= $product["product_name"] ?>">
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

                    <div class="card-body">
                        <h5 class="card-title"><?= ($product["product_name"]) ?></h5>
                        <p class="card-text"><?= ($product["product_description"]) ?></p>
                        <p class="card-text">PRIX : <?= ($product["product_price"]) ?> €</p>
                        <p class="card-text">Catégorie : <?= ($product["product_category"]) ?></p>
                        <p class="card-text">Nombre de produit(s) en stock : <?= ($product["product_stock"]) ?></p>
                        <p class="card-text">Vendeur : <?= ($product["product_owner"]) ?></p>
                        <a href="details-produits?id=<?php echo $product["product_id"] ?>" class="btn btn-warning">Détails</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>






