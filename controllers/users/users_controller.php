
<?php
    require_once "../models/users/users_model.php";

    function RegisterUsersController(): bool{
        $users_model = new UsersModel();
        $form_is_valid = false;
        if(isset($_POST["btn-register"])){
                if(empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["password_repeat"])){
                    echo "<div class='alert alert-danger p-3'>Merci de remplir tous les champs !</div>";
                    return false;
                }else{
                    $form_is_valid = true;
                }
                 //PASSWORD REPEAT
                if($_POST["password_repeat"] != $_POST["password"]){
                    echo "<div class='alert alert-danger p-3'>Les mot de passe sont différents !</div>";
                    return false;
                }else{
                    $form_is_valid = true;
                }

                if($form_is_valid && $users_model->RegsiterUser()){
                    echo "<div class='alert alert-success p-3'>
                        <div>
                        Merci pout votre inscription !
                        </div>
                        <a href='connexion' class='btn btn-success mt-3'>Se connecter</a>
                        </div>";
                        return true;
                }else{
                    echo "<div class='alert alert-danger p-3'>
                        <div>
                        Erreur lors de votre inscription !
                        </div>
                        <a href='inscription' class='btn btn-danger mt-3'>Recommencer</a>
                        </div>";
                        return false;
                }

                
      
        }
        return false;
    }

?>