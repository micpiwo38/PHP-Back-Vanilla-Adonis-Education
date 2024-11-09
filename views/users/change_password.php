<?php
$email = $_GET["key"];
$id = $_GET["id"];

var_dump($email);
var_dump($id);

?>

<div class="container shadow rounded w-50 p-3">
    <form method="POST">
        <div class="mt-3">
            <label for="new_password">Votre nouveau mot de passe</label>
            <input type="password" class="form-control" name="new_password" id="new_password">
        </div>

        <div class="mt-3">
            <label for="new_password_repeat">Votre nouveau mot de passe</label>
            <input type="password" class="form-control" name="new_password_repeat" id="new_password_repeat">
        </div>

        <div>
            <button name="btn-change-password" class="btn btn-warning mt-3">Valider le nouveau mot de passe</button>
        </div>
    </form>
</div>
