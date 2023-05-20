<?php
/**
 * Connection à la base de données
 * effectuer une requete pour verifier
 * Si l'utilisateur existe 
 */
$dsn = 'mysql:db=BD_CHAT;host=localhost';
$pdo = new PDO($dsn, 'ubuntu', 'Demonone@12345');

/**
 * Cette fonction modifie le titre de la page d'authentification
 * dans le cas de la création ou de la connexion d'un utilisateur
 *
 * @return void
 */
function h1_toogle()
{
    if (isset($_GET["AM-create_account"])) {

        if ($_GET["AM-create_account"] == "T") {
            echo "<h1 id=c-o-l>";
            // S'enregistrer
            // echo "Sign up";
            echo "Créer un compte";
            echo "</h1>";
        }
    } else {
        echo "<h1 id=c-o-l>";
        // Se connecter 
        // echo "Sign in";
        echo "Se connecter";
        echo "</h1>";
    }
}

/**
 * Cette fonction modifie le lien de redirection  
 * pour alterner entre Connection et création d'un utilisateur
 *
 * @return void
 */
function link_toogle()
{
    if (isset($_GET["AM-create_account"])) {

        if ($_GET["AM-create_account"] == "T") {
            echo "<a href='./mon_site_mes.php' id='account'>Vous avez un compte</a>";
        }
    } else {
        echo "<a href='./mon_site_mes.php?AM-create_account=T' id='account'>Vous n'avez pas de compte</a>";
    }
}

/**
 * Cette fonction modifie la valeur du bouton 
 * dans le cas de la Connection et création d'un utilisateur
 *
 * @return void
 */
function button_value_toogle()
{
    if (isset($_GET["AM-create_account"])) {

        if ($_GET["AM-create_account"] == "T") {
            echo "<input name=action type='submit' id='sub' value='Valider'>";
        }
    } else {
        echo "<input name=action type='submit' id='sub' value='Connexion'>";
    }
}

/**
 * Cette fonction affiche le formulaire 
 * de connection ou de création d'un utlisateur en fonction du lien 
 * @param int $id_err Erreur  
 * @param string $error_message Message d'erreur
 * 
 * @return void
 */
function echo_form($id_err = null, $error_message = null)
{
    h1_toogle();
    echo "<embed src='./xml/fichier.xml' type='text/xml'>";
    if ((isset($_GET["AM-create_account"]) && ($_GET["AM-create_account"] == "T")) || !isset($_GET["AM-create_account"])) {

        if ($error_message != null) {
            echo "<p id=error_message_" . $id_err . ">" . $error_message . "</p>";
        }
        echo "<form class=container action='./mon_site_mes.php' method='post'>
            <div class=form-group>
                <input name=username type='text' class=form-input id=form-login placeholder='Login' required>
                <label class=form-label for='form-login'>Username</label>
            </div>
            <div class=form-group>
                <input name=password type='password' class=form-input id=form-psw placeholder='Mot de passe :' required>
                <label class=form-label for='form-psw'>Mot de passe</label>
            </div>
            <div class='form-group'>";
        button_value_toogle();
    }

    link_toogle();
    echo "</div>";
    echo "</form>";
    echo "<script src='./js/check_usr_psw.js'></script>";

}

/**
 * Affiche le site web
 * @return void
 */
function echo_website()
{
    echo "
    <embed src='./xml/fichier.xml' type='text/xml'>
  <div class=container-group>

    <div id=container1>
      <nav>
        <ul>
          <li id=log-out>
            <i class='bi bi-box-arrow-left'></i>
          </li>
          
        </ul>
      </nav>
      <div id=usr-con>
        <div id=con>
          <i class='bi bi-people-fill'></i>
          Connecté
        </div>
        <div id=usr>
            
        </div>

      </div>
    </div>  
    
    <div id=container2>
      
      <div id=receiver>
        
        </div>
        
        <div id=sender>
          <!-- <input type='text' name='message' id='mes'> -->
          <div id=m>
            <textarea id=mes name=message placeholder='Message...'></textarea>
            <label for='mes' id=mes-label>Message</label>
          </div>
          <button id=send-button><i class='bi bi-send'></i></button>
        </div>
      </div>
    </div>
      
      <script src='./js/fichier.js'></script>
      <script src='./js/fichier1.js'></script>
";
}
/**
 * Cette fonction vérifie si le messages n'est pas vide le
 *
 * @param string $message
 * @return boolean true si le messages est vide et false sinon
 */
function check_empty($message)
{
    if (gettype($message) == 'string') {

        for ($index = 0; $index < strlen($message); $index++) {
            if ($message[$index] != ' ') {
                return false;
            }
        }
        return true;
    } else {
        fprintf(STDERR, "%s\n", "Veuillez passer en argument une chaine de caractère");
        exit(1);
    }

}


?>