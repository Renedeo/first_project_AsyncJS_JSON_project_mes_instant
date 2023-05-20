<?php
if (isset($_SERVER['HTTP_USER_AGENT'])) {
    include("./php/fonction.php");
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Messagerie instantannée</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="./css/form_style.css">

    <link rel="stylesheet" href="./css/disposition.css">
    <link rel="stylesheet" href="./css/nav-style.css">
    <link rel="stylesheet" href="./css/container1-style.css">
    <link rel="stylesheet" href="./css/container2-style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body>
    <?php
    if (isset($_SERVER['HTTP_USER_AGENT'])) {
        // Deconnenction 
        if (isset($_GET['disconnect'])) {
            $disconnect_value = $_GET['disconnect'];
            // En fonction de ma requete get
            if ($disconnect_value == "T") {
                echo "<h1>
            Thanks for using our chat, try reconnect another time
            </h1>
            ";
                // Formulaire de connexion 
                echo_form();

                // Destruction de la session 
                if (isset($_SESSION["session_id"])) {

                    // Deconnexion
                    $req1 = "UPDATE BD_CHAT.`User` 
                            SET `Connected` = '0' 
                            WHERE `id_user` = " . $_SESSION['session_id'] . ";";
                    $rep1 = $pdo->query($req1);
                    session_unset();
                    session_destroy();
                }
            }

        } elseif (isset($_SESSION['session_id'])) {
            echo_website();
            // session_destroy();
    
        } else {

            /**
             * Si le formulaire a déjà été valider
             * Cela implique que le nom d'utilisateur
             *  et le mot de passe est renseignée
             * --------------------------------------
             */
            if (isset($_POST['username'])) {
                $username = $_POST['username'];

                if (isset($_POST['password'])) {
                    $password = $_POST['password'];
                    // Mot de passe chiffrées
                    $psw_hash = password_hash($password, PASSWORD_ARGON2I);
                    $_POST['password'] = $psw_hash;

                    /**
                     * On doit vérifier comment le formulaire
                     *  a été validée 
                     * Si la valeur du bouton de confirmation 
                     *  est valider ---> Création d'un compte
                     *  est connexion -> Connexion au site
                     * -------------------------------------
                     */
                    if (isset($_POST['action'])) {
                        $action = $_POST['action'];

                        /**
                         * Nous devons dès à présent verifier l'existance
                         *  de l'utilisateur du site dans la base de données
                         */
                        $req = 'SELECT *
                           FROM BD_CHAT.`User` 
                           WHERE username="' . $username . '";';
                        $rep = $pdo->query($req);

                        // Nombre d'utilisateur avec cette username
                        $nb_user = $rep->rowCount();

                        /**
                         * Si acucun compte ne correspond à l'username 
                         *   entrée par l'utilisateur 
                         * En fonction de la confirmation du formulaire
                         * on aura les cas suivants
                         *  Valider ----------------------------------- 
                         *    -> Pas de compte 
                         *          Création du compte 
                         *          Redirection vers Connexion ----
                         *    -> Un compte existant 
                         *          Annulation de la création 
                         *          Erreur de création ----------------
                         *    -> Plusieurs compte existant
                         *          Annulation de la création
                         *          Erreur venant de la base de données-
                         * 
                         *  Connexion
                         *    -> Pas de compte 
                         *          Annulation de la connexion
                         *          Erreur de connexion ---------------
                         *    -> Un compte existant 
                         *          Vérification du mot de passe------- 
                         *          ----> Connexion au site -----------
                         *    -> Plusieurs compte existant
                         *          Annulation de la connexion
                         *          Erreur venant de la base de données-
                         * ---------------------------------------------
                         */
                        if ($nb_user == 0) {
                            if ($action == 'Valider') {

                                // Insertion dans la table User 
                                $req = 'INSERT INTO BD_CHAT.`User`(username, passwords, FontFamily_id) 
                                    VALUES ("' . $username . '","' . $psw_hash . '",
                                    (SELECT `FontFamily_id` FROM BD_CHAT.`FontFamily` ORDER BY RAND() LIMIT 1))';
                                $rep = $pdo->query($req);

                                // Redirection vers le site pour se connecter
                                echo "<script src='./js/redirection.js'></script>";

                            } elseif ($action == 'Connexion') {
                                echo_form(
                                    $id_err = 0,
                                    $error_message = "Compte inexistant"
                                );
                            }

                        } elseif ($nb_user == 1) {
                            if ($action == 'Valider') {
                                echo_form(
                                    $id_err = 1,
                                    $error_message = "Username existant"
                                );

                            } elseif ($action == 'Connexion') {
                                // Verification du mot de passe 
                                $rep = $rep->fetch(PDO::FETCH_NUM);
                               
                                if (password_verify($password, $rep[2])) {
                                    // User existant 
                                    // Démarrage de la session
                                    $_SESSION['session_id'] = $rep[0];
                                    $_SESSION['username'] = $rep[1];
                                    $req1 = "UPDATE BD_CHAT.`User` 
                                            SET `Connected` = '1' 
                                            WHERE `id_user` = " . $rep[0] . ";";
                                    $rep1 = $pdo->query($req1);
                                    echo_website();
                                } else {
                                    echo_form(
                                        $id_err = 2,
                                        $error_message = "Mot de passe incorrecte"
                                    );

                                }

                            }
                        // On a pas plus d'un utilisaeurs dans les tables
                        } elseif ($nb_user > 1) {

                            echo_form(
                                $id_err = -1,
                                $error_message = "Plusieurs comptes existant avec ce nom d'utilisateur<br/>, Ce n'est pas vous c'est nous"
                            );
                        }
                    }
                } else {
                    echo_form();
                }
            } else {
                echo_form();
            }
        }
    }
    ?>
</body>

</html>