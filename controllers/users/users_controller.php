<?php
require_once "../models/users/users_model.php";

//CONNEXION
function LoginUsersController(): bool
{
    $user_model = new UsersModel();
    if(isset($_POST["btn-login"])){
        if(isset($_POST["email"]) && isset($_POST["password"])){
            if($user_model->LoginUser()){
                header("Location: profile");
                return true;
            }else{
                echo "<div class='alert alert-danger p-3'>Erreur lors de votre tentative de connexion ! Merci de vérifié votre email et mot de passe !
                        <hr>
                            <a href='connexion' class='btn btn-warning mt-3'>Recommencer</a>
                        <hr>
                </div>";
            }
        }
    }
    return false;
}
//INSCRIPTION
function RegisterUsersController(): bool
{
    $users_model = new UsersModel();
    if (isset($_POST["btn-register"])) {
        if (empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["password_repeat"])) {
            echo "<div class='alert alert-danger p-3'>Merci de remplir tous les champs !</div>";
            return false;
        } else {
            $form_is_valid = true;
        }
        //PASSWORD REPEAT
        if ($_POST["password_repeat"] != $_POST["password"]) {
            echo "<div class='alert alert-danger p-3'>Les mot de passe sont différents !</div>";
            return false;
        } else {
            $form_is_valid = true;
        }

        if ($form_is_valid && $users_model->RegsiterUser()) {
            echo "<div class='alert alert-success p-3'>
                        <div>
                        Merci pout votre inscription !
                        </div>
                        <a href='connexion' class='btn btn-success mt-3'>Se connecter</a>
                        </div>";
            return true;
        } else {
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
//SUPRESSION
function DeleteUserController(): bool{
    $users_model = new UsersModel();
    if(isset($_POST["btn-delete"])){
        $users_model->DeleteUser();
        header("Location: delete_user_message");
        return true;
    }
    return false;
}
//Mise a jour = changer de mot de passe
function UpdateUserController() : bool{
    $user_model = new UsersModel();
    if(isset($_POST["btn-update"])){
        $user_model->UpdateUser();
        echo "<div class='alert alert-success p-3'>
                <p>Un email vous a été envoyé pour modifier votre mot de passe !</p>
            </div>
            <em>Cordialement : Mic-Office Administration</em>";
        return true;
    }
    return false;
}

//Valider le nouveau mot de passe
function ValidateNewPasswordController(): bool{
    $user_model = new UsersModel();
    if(isset($_POST["btn-change-password"])){
        $user_model->ValidateNewPassword();
        return true;
    }
    return false;
}

//CONNEXION ADMINISTRATEUR
function LoginAsAdminController(){
    $user_model = new UsersModel();
    if(isset($_POST["btn-login"])){
        if(isset($_POST["email"]) && isset($_POST["password"])){
            if($user_model->LoginAdmin()){
                if($_SESSION["is_admin"]){
                    header("Location: administration");
                    return true;
                }
            }else{
                echo "<div class='alert alert-danger p-3'>Erreur lors de votre tentative de connexion ! Merci de vérifié votre email et mot de passe !
                        <hr>
                            <a href='connexion' class='btn btn-warning mt-3'>Recommencer</a>
                        <hr>
                </div>";
            }
        }
    }
    return false;
}
?>