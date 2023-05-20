<?php

include("fonction.php");
session_start();
if (isset($_SESSION['session_id'])) {
    $id_user = $_SESSION['session_id'];

    if (isset($_POST['phase'])) {
        $phase = $_POST['phase'];

        if ($phase == 'send') {
            if (isset($_POST['mes'])) {
                $message = $_POST['mes'];

                if (!check_empty($message)) {
                    /**
                     * Insertion dans la base de données
                     * id_user
                     * message
                     * le message ne sera pas afficher, donc display = False
                     * date d'envoie du message
                     */
                    $date_format = $_POST['date'];
                    $milliseconde = $_POST['date_milliseconds'];

                    // var_dump($_POST);
                    $requete = 'INSERT INTO BD_CHAT.`Message` 
                            (id_user,
                             content,
                              `date`,
                              milliseconds) 
                            VALUES (' . $id_user . ',"'
                        . $message . '","'
                        . $date_format . '",'
                        . $milliseconde . ');';

                    $_SESSION['start_date'] = $date_format;
                    $reponse = $pdo->query($requete);
                }
            }
        } else {

            // ---------------------------------------------------
            $req = 'SELECT u.id_user, u.username, f.font_family 
                    FROM BD_CHAT.`User` u 
                    INNER JOIN BD_CHAT.FontFamily f 
                    ON u.FontFamily_id = f.FontFamily_id;';

            $rep = $pdo->query($req);
            // $rep = $rep->fetchAll();

            $result = array();
            while ($row = $rep->fetch(PDO::FETCH_ASSOC)) {
                $result[$row["id_user"]]["username"] = $row["username"];
                $result[$row["id_user"]]["font_family"] = $row["font_family"];
            }
            // ---------------------------------------------------
            $requete = 'SELECT * FROM `BD_CHAT`.Message;';
            $reponse = $pdo->query($requete);
            $reponse = $reponse->fetchAll(PDO::FETCH_ASSOC);

            // ----------------------------------------------------
            $send = array(
                "user_info" => $result,
                "user" => $id_user,
                "rep" => $reponse,
                "fontfamily" => '',
            );

            $reponse = json_encode($send);
            echo $reponse;
        }
    }
}


?>