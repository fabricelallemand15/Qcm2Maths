<?php session_start();
require('config.php');
include("head.php");
include("header.php"); 


if (!isset($_POST['mail_hash']) or !isset($_POST['mdp']) or !isset($_POST['mdp2']) or $_POST['mail_hash'] == NULL or $_POST['mdp'] == NULL or $_POST['mdp2'] == NULL) {

    echo "Vous ne devriez pas être ici : <a href='index.php'>Retour</a>";
    die();
} 

?>
<div id="liveAlertPlaceholder"></div> 
<?php

// On vérifie que les mots de passe sont identiques


if ($_POST['mdp'] != $_POST['mdp2']) {
    echo '<script type="text/javascript">                 
                    BSalert("Les mots de passe ne sont pas identiques", "danger")
                </script>';
    echo "<a href='new_pwd.php?mail=".$_POST['mail_hash']."'>Retour</a>";
} else {
    // on recherche dans la base le mail qui a le même hash
    $base = $bdd->prepare('SELECT * FROM utilisateur');
    $base->execute();
    $donnees = $base->fetch();
    // echo $donnees['mail'];
    // $trouve = false;
    while ($donnees != NULL) {
        if (hash('sha256', $donnees['mail']) == $_POST['mail_hash']) {
            $mail = $donnees['mail'];
            // echo $mail;
            // $trouve = true;
            break;
        }
        $donnees = $base->fetch();
    }
        // mise à jour du hash de mot de passe dans la base de données
        // echo "test";
        $requete = $bdd->prepare('UPDATE utilisateur SET mdp = ? WHERE mail = ?');
        $requete->execute(array(hash('sha256', $_POST['mdp']), $mail));
        // echo $requete->rowCount();
        // on affiche un message de succès
        echo '<script type="text/javascript">                 
                    BSalert("Votre mot de passe a été modifié avec succès", "success")
                </script>';

        // on affiche un lien vers la page de connexion
        echo "<a href='index.php'>Retour</a>";

    }

include("footer.php") ?>