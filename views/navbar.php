<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">MIC-OFFICE</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="profile">Profile <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="liste-produits">TOUS LES PRODUITS</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="liste-produits-utilisateur">Gestion de vos produits</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Rechercher" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
            <?php
                if($_SESSION["is_login"]){
                    ?>
                    <a href="deconnxion" class="btn btn-outline-danger mx-2 my-2 my-sm-0" type="submit">DECONNEXION</a>
                    <?php
                }
            ?>
        </form>
    </div>
</nav>