
<div class="container w-25 rounded shadow mt-5 p-5">
    <form method="POST">
        <h2 class="text-info">INSCRIPTION</h2>
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Email</label>
        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp">
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Mot de passe</label>
        <input type="password" class="form-control" name="password" id="exampleInputPassword1">
    </div>

    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Repeter le mot de passe</label>
        <input type="password" class="form-control" name="password_repeat" id="exampleInputPassword1">
    </div>

    <button type="submit" name="btn-register" class="btn btn-warning">INSCRIPTION</button>
    <hr>
    <div>Déja inscrit ?
    <a href="connexion">Se connecter</a>
    </div>
    <hr>
    </form>
</div>