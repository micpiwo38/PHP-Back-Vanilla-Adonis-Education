<?php
    if($_SESSION["is_login"]){
        ?>
            <div class="container shadow rounded w-50 mt-5 p-3 ">
                <h1 class="text-success">Bienvenue : <?= $_SESSION["email"] ?></h1>
                <p>ID = <?= $_SESSION["user_id"] ?></p>
                <a href="deconnexion" class="btn btn-warning mt-3">DECONNEXION</a>
                <h2 class="text-info mt-3">Gestion de votre compte :</h2>
                <form method="POST">
                    <button name="btn-delete" class="btn btn-danger mt-3">Supprimer votre compte</button>
                    <button name="btn-update" class="btn btn-info mt-3">Changer de mot de passe</button>
                </form>
                <h3 class="text-dark mt-3">Administer vos produit(s) :</h3>
            </div>

        <?php
    }else{
        echo "Cette page n'est accessible qu'aux utilisateurs inscrits !";
    }
?>