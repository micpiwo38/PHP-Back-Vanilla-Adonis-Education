<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require_once "../models/database.php";
    require_once "../vendor/phpmailer/phpmailer/src/Exception.php";
    require_once "../vendor/phpmailer/phpmailer/src/PHPMailer.php";
    require_once "../vendor/phpmailer/phpmailer/src/SMTP.php";

    class UsersModel{

        private $user_id;
        private $user_email;
        private $user_password;
        private $user_role;
        private $user_is_active = 0;

        private PDO $db;

        //Connexion a l'aide du singleton
        public function __construct()
        {
            $this->db = Database::getPDOInstance()->GetPDOConnexion();
        }
        //Connexion
        public function LoginUser() : bool {
            $this->user_email = trim(htmlspecialchars($_POST["email"]));
            $this->user_password = trim(htmlspecialchars($_POST["password"]));
            $this->user_role = "user";

            //Requete SQL find by email & role
            $sql = "SELECT * FROM users WHERE email = ? AND role = ?";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(1, $this->user_email);
            $statement->bindParam(2, $this->user_role);
            $statement->execute([
                $this->user_email,
                $this->user_role
            ]);

            //Lister les utilisateurs inscrits => au moin 1 user dans la table
            if($statement->rowCount() >= 1){
                $row = $statement->fetch();
                //Redirection différente en cas de succès et de role
                if($this->user_email == $row["email"] && password_verify($this->user_password, $row["password"]) && $this->user_role == $row["role"]){
                    //Si role = user
                    if($row["role"] === "user"){
                        session_start();
                        $_SESSION["is_login"] = true;
                        $_SESSION["user_id"] = $row["id"];
                        $_SESSION["email"] = $this->user_email;
                        $_SESSION["password"] = $this->user_password;
                        $_SESSION["role"] = $this->user_role;

                        return true;

                    }else{
                        echo "Tu es connecté en tant qu' Admin";
                        return true;
                    }
                }else{
                    "<div class='alert alert-danger p-3'>Erreur lors de votre connexion, merci de verifié votre email et mot de passe 
                        <a href='inscription'>Recommencer</a>
                    </div>";
                }
            }else{
                "<div class='alert alert-danger p-3'>Cette email est inconnu !
                        <a href='inscription'>Recommencer</a>
                    </div>";
            }
            return false;
        }
        //Inscription
        public function RegsiterUser() : bool {
            //Champs du formulaire
            if(isset($_POST["email"]) && !empty($_POST["email"])){
                $this->user_email = trim(htmlspecialchars($_POST["email"]));
            }else{
                echo "<div class='alert alert-danger p-3'>Merci de remplir tous les champs !</div>";
            }

            //PASSWORD
            if(isset($_POST["password"]) && !empty($_POST["password"])){
                $this->user_password = trim(htmlspecialchars($_POST["password"]));
            }else{
                echo "<div class='alert alert-danger p-3'>Merci de remplir tous les champs !</div>";
            }

            //SQL
            //Check user already exist
            $sql_user_exist = "SELECT * FROM users WHERE email = ?";
            $check_user_exist = $this->db->prepare($sql_user_exist);
            $check_user_exist->execute([$this->user_email]);
            $users = $check_user_exist->fetch();
            if($users){
                echo "<div class='alert alert-danger p-3'>Cet email n'est pas disponible
                    <a href='inscription'>Recommencer</a>
                </div>";
            }else{
                $sql = "INSERT INTO users (email, password, role) VALUES (?,?,?)";
                //Role par defaut
                $this->user_role = "user";
                $statement = $this->db->prepare($sql);
                $statement->bindParam(1, $this->user_email);
                $hash_password = password_hash($this->user_password, PASSWORD_DEFAULT);
                $statement->bindParam(2, $hash_password);
                $statement->bindParam(3, $this->user_role);

                $statement->execute([
                    $this->user_email,
                    $hash_password,
                    $this->user_role
               ]);
               $is_register = true;

               if($is_register){
                    //Instance de la classe PHPMailer
                    $phpmailer = new PHPMailer();
                    try{
                        //CONFIGURATION PHPMAILET -> Hote = MailTrap
                        $phpmailer->isSMTP(); //Protocole Simlpe Mail Transport Protocol
                        $phpmailer->Host = 'sandbox.smtp.mailtrap.io'; // hote mailtrap => https://mailtrap.io/inboxes/1163067/messages
                        $phpmailer->SMTPAuth = true; // autorise et impose email + password
                        $phpmailer->Port = 2525; // Port SMPT
                        $phpmailer->Username = '5c8396efb85ec3'; //User => mailtrap
                        $phpmailer->Password = 'f26eb6f125373d'; //Password mailtrap
                        $phpmailer->setLanguage('fr', '../vendor/phpmailer/phpmailer/language/');
                        $phpmailer->CharSet = 'UTF-8';

                        //Envoyeur et destinataire
                        $phpmailer->setFrom('mic_office@gmail.com', ' Administration Mic_Office');
                        $phpmailer->addAddress('mic_office@gmail.com', 'Administrateur Mic_Office.com');
                        $phpmailer->addReplyTo('mic_office@gmail.com', 'Administration Mic_Office');
                        //Format HTML
                        $phpmailer->isHTML(true);
                        //ATTENTION on passe de mailTrap a notre site URL est absolue = localhost/votreprojet/route
                        $redirect = "http://127.0.0.1/mic_office/connexion";
                         //Corp de la page HTML5 = ici le css est dans les balises
                        $phpmailer->Body = '
                        <!DOCTYPE html>
                        <html lang="fr">
                        <head>
                            <meta charset="UTF-8">
                            <meta http-equiv="Content-Type" content="text/html">
                            <title>Votre inscription sur Mic_Office.com</title>
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        </head>
                        <body style="color: #43617f; font-size: 22px;text-align: center; padding: 20px">
                        <div style="padding: 20px;">
                            <img src="https://t3.ftcdn.net/jpg/04/77/73/44/360_F_477734432_l1srDtzmuvtWUTkt6BVaRJ2mW2faXdTo.jpg" width="64px" height="64px" alt="" title="mic_office.com">
                        </div>
                        <div style="padding: 20px;">
                            <h1>Mic_Office.com</h1>
                            <h2>Bonjour : '.$this->user_email.'</h2>
                            <p>Vous êtes desormais inscrit sur le site Mic_Office.com merci de valider votre inscription avec le liens suivant</p><br />
                            <p>Recapitulatif de vos information de connexion</p>                      
                            <p>Email :<b style="color: #8b0000"> '.$this->user_email.'</b></p>
                            <p>Mot de passe :<b style="color: #8b0000;">'.$this->user_password.'</p>
                            <br /><br />
                            <a href="' . $redirect . '" style="background-color: darkred; color: #F0F1F2; padding: 20px; text-decoration: none;">Confimer votre inscription sur notre site</a><br />
                            <br /><br />                      
                            <p style="color: #43617f;">Merci d\'utiliser notre site web</p>
                            <p style="color: #43617f;">Cordialement : Annonces.com: Michael MICHEL : Administrateur</p>    
                        </div>
                        </body>
                        </html>
                        ';

                //Envoi de email
                $phpmailer->send();
                 //Message de succes + bouton pour aller a la connexion
                 echo "<div class='container text-center'>
                 <div class='w-100 alert alert-success text-center'>Merci pour votre inscription, 
                 un email de validation vous à été envoyé, merci de validé votre inscription pour acceder à votre tableau de bord.</div>                                                     
                </div>";


                    }catch(Exception $e){
                        "<div class='alert alert-danger p-3'>Erreur lors de votre inscription".$e->getMessage()."
                        <a href='inscription'>Recommencer</a>
                    </div>";
                    }

                    return $is_register;
               }else{
                "<div class='alert alert-danger p-3'>Erreur lors de votre inscription</div>";
                $is_register = false;
                return $is_register;
               }

            }
            $is_register = false;
            return $is_register;

        }
        //Supprimer un compte
        public function DeleteUser(){
            $sql = "DELETE FROM users WHERE id = ?";
            $statement = $this->db->prepare($sql);
            $this->user_id = $_SESSION["user_id"];
            $statement->bindParam(1, $this->user_id);
            $statement->execute([
                $this->user_id
            ]);
        }
        //Envoyer email changement de mot de passe
        public function UpdateUser()
        {

            $this->user_email = trim(htmlspecialchars($_POST["email"]));
            $sql = "SELECT * FROM users WHERE email = ?";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(1, $this->user_email);
            $password_update = $statement->execute([$this->user_email]);

            if ($password_update) {
                //Instance de la classe PHPMailer
                $phpmailer = new PHPMailer();
                try {
                    //CONFIGURATION PHPMAILET -> Hote = MailTrap
                    $phpmailer->isSMTP(); //Protocole Simlpe Mail Transport Protocol
                    $phpmailer->Host = 'sandbox.smtp.mailtrap.io'; // hote mailtrap => https://mailtrap.io/inboxes/1163067/messages
                    $phpmailer->SMTPAuth = true; // autorise et impose email + password
                    $phpmailer->Port = 2525; // Port SMPT
                    $phpmailer->Username = '5c8396efb85ec3'; //User => mailtrap
                    $phpmailer->Password = 'f26eb6f125373d'; //Password mailtrap
                    $phpmailer->setLanguage('fr', '../vendor/phpmailer/phpmailer/language/');
                    $phpmailer->CharSet = 'UTF-8';

                    //Envoyeur et destinataire
                    $phpmailer->setFrom('mic_office@gmail.com', ' Administration Mic_Office');
                    $phpmailer->addAddress('mic_office@gmail.com', 'Administrateur Mic_Office.com');
                    $phpmailer->addReplyTo('mic_office@gmail.com', 'Administration Mic_Office');
                    //Format HTML
                    $phpmailer->isHTML(true);
                    //ATTENTION on passe de mailTrap a notre site URL est absolue = localhost/votreprojet/route + email concerné + id unique
                    $redirect = "http://127.0.0.1/mic_office/change_password?key=".$this->user_email."&id=".uniqid();
                    //Corp de la page HTML5 = ici le css est dans les balises
                    $phpmailer->Body = '
                        <!DOCTYPE html>
                        <html lang="fr">
                        <head>
                            <meta charset="UTF-8">
                            <meta http-equiv="Content-Type" content="text/html">
                            <title>Changer mot de passe Mic_Office.com</title>
                            <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        </head>
                        <body style="color: #43617f; font-size: 22px;text-align: center; padding: 20px">
                        <div style="padding: 20px;">
                            <img src="https://t3.ftcdn.net/jpg/04/77/73/44/360_F_477734432_l1srDtzmuvtWUTkt6BVaRJ2mW2faXdTo.jpg" width="64px" height="64px" alt="" title="mic_office.com">
                        </div>
                        <div style="padding: 20px;">
                            <h1>Mic_Office.com</h1>
                            <h2>Bonjour : ' . $this->user_email . '</h2>
                            <p>Vous pouvez modifier votre mot de passe avec le liens suivant</p><br />
                            
                            <br /><br />
                            <a href="' . $redirect . '" style="background-color: darkred; color: #F0F1F2; padding: 20px; text-decoration: none;">Modifier votre mot de passe</a><br />
                            <br /><br />                      
                            <p style="color: #43617f;">Merci d\'utiliser notre site web</p>
                            <p style="color: #43617f;">Cordialement : Annonces.com: Michael MICHEL : Administrateur</p>    
                        </div>
                        </body>
                        </html>
                        ';

                    //Envoi de email
                    $phpmailer->send();
                }catch(Exception $e){
                    "<div class='alert alert-danger p-3'>Erreur lors de votre inscription".$e->getMessage()."
                        <a href='inscription'>Recommencer</a>
                    </div>";
                }
                return true;
            }
            return  false;
        }
        //Valider le nouveau mot de passe UPDATE
        public function ValidateNewPassword() : bool{
            //Check user exist = email dans URL
            $this->user_email = $_GET["key"];
            $this->user_role = "user";
            $unique_id = $_GET["id"];
            $sql_users_exist = "SELECT * FROM users WHERE email = ?";
            $check_user_exist = $this->db->prepare($sql_users_exist);
            $check_user_exist->bindParam(1, $this->user_email);
            $check_user_exist->execute([$this->user_email]);
            $user = $check_user_exist->fetch();
            if(!$user && $unique_id){
                echo "<div class='alert alert-danger p-3'>Cet email est inconnu !
                    <a href='inscription'>Recommencer</a>
                </div>";
            }else {
                //Champ du formulaire
                //PASSWORD
                if (isset($_POST["new_password"]) && !empty($_POST["new_password"])) {
                    $this->user_password = trim(htmlspecialchars($_POST["new_password"]));
                } else {
                    echo "<div class='alert alert-danger p-3'>Merci de remplir tous les champs !</div>";
                }
                $sql = "UPDATE users SET email = ?, password = ?, role = ?, is_active = ? WHERE id = ?";
                //Param ID unique dans url
                $this->user_id = $user["id"];
                var_dump($user["id"]);
                $hash_password = password_hash($this->user_password, PASSWORD_DEFAULT);
                $statement = $this->db->prepare($sql);
                $statement->bindParam(1, $this->user_email);
                $statement->bindParam(2, $hash_password);
                $statement->bindParam(3, $this->user_role);
                $statement->bindParam(4, $this->user_is_active);
                $statement->bindParam(5, $this->user_id);

                $new_password = $statement->execute([
                    $this->user_email,
                    $hash_password,
                    $this->user_role,
                    $this->user_is_active,
                    $this->user_id
                ]);
                var_dump($statement);
                if ($new_password) {

                    var_dump($this->user_id);
                    echo "<div class='alert alert-success p-3'>
                        Votre mot de passe a bien été modifié
                        <a href='connexion'>Connexion</a>
                    </div>";
                    return true;
                } else {
                    echo "<div class='alert alert-danger p-3'>
                        Erreur lors de la modification de mot de passe                
                    </div>";
                }
            }

            return false;
        }
        //Connexion ADMINSTRATEUR
        public function LoginAdmin() : bool {
            $this->user_email = trim(htmlspecialchars($_POST["email"]));
            $this->user_password = trim(htmlspecialchars($_POST["password"]));
            $this->user_role = "admin";

            //Requete SQL find by email & role
            $sql = "SELECT * FROM users WHERE email = ? AND role = ?";
            $statement = $this->db->prepare($sql);
            $statement->bindParam(1, $this->user_email);
            $statement->bindParam(2, $this->user_role);
            $statement->execute([
                $this->user_email,
                $this->user_role
            ]);

            //Lister les utilisateurs inscrits => au moin 1 user dans la table
            if($statement->rowCount() >= 1){
                $row = $statement->fetch();
                //Redirection différente en cas de succès et de role
                if($this->user_email == $row["email"] && password_verify($this->user_password, $row["password"]) && $this->user_role == $row["role"]){
                    //Si role = user
                    if($row["role"] === "admin"){
                        session_start();
                        $_SESSION["is_admin"] = true;
                        $_SESSION["user_id"] = $row["id"];
                        $_SESSION["email"] = $this->user_email;
                        $_SESSION["password"] = $this->user_password;
                        $_SESSION["role"] = $this->user_role;

                        return true;

                    }else{
                        echo "Erreur de connexion";
                        return true;
                    }
                }else{
                    "<div class='alert alert-danger p-3'>Erreur lors de votre connexion, merci de verifié votre email et mot de passe 
                        <a href='inscription'>Recommencer</a>
                    </div>";
                }
            }else{
                "<div class='alert alert-danger p-3'>Cette email est inconnu !
                        <a href='inscription'>Recommencer</a>
                    </div>";
            }
            return false;
        }


    }

?>
