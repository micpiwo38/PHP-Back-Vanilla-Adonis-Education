<div class="container-fluid">
    <?php require_once "./navbar.php"?>
</div>

<?php
    if($_SESSION["is_login"]){
        ?>

            <div class="container shadow rounded w-50 mt-5 p-3 ">
                <h1 class="text-success">Bienvenue : <?= $_SESSION["email"] ?></h1>
                <a href="deconnexion" class="btn btn-warning mt-3">DECONNEXION</a>
                <h2 class="text-info mt-3">Gestion de votre compte :</h2>
                <form method="POST">
                    <button name="btn-delete" class="btn btn-danger mt-3">Supprimer votre compte</button>
                </form>

                <h3 class="text-warning mt-3">Gestion de vos données :</h3>
                <a href="liste-produits-utilisateur" class="btn btn-success mt-3">Gerer vos produits</a>
            </div>

        <?php
    }else{
        echo "Cette page n'est accessible qu'aux utilisateurs inscrits !";
    }
?>