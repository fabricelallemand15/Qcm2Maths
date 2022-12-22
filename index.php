<?php 
session_start();
include("head.php");
require('config.php');
?>

<div id="login">
<h2>Bienvenue sur Qcm2Maths</h2>
<div>
    <form id="form_login" action="" method="post">
            <img class="mb-4" src="images/logo_qcm2maths.png" alt="logo" id="logo">
            <h1 class="h3 mb-3 fw-normal">Authentification</h1>
            <div class="d-grid gap-2">
                <input type="email" name="email" id="email" placeholder="Email" autocomplete="email" required/>
                <input type="password" name="mdp" id="mdp" placeholder="Mot de passe"  autocomplete="new-password" required/>
                <button class="w-100 btn btn-lg btn-success" type="submit">Valider</button>
                <button class='w-100 btn btn-lg btn-primary' type="button" onclick="location.href = 'nouvel-utilisateur.php';">Nouvel utilisateur ?</button>
                <button class='w-100 btn btn-lg btn-warning' type="button" onclick="">Mot de passe oublié ?</button>
                <div id="liveAlertPlaceholder"></div>   
            </div>
            
    </form>
</div>

<script type="text/javascript" src="js/BSalert.js"></script>

<?php
if (!isset($_POST['mdp']) or !isset($_POST['email']) or $_POST['mdp'] == NULL or $_POST['email'] == NULL) {

    echo '';
} else {

    /* Récupération des infos de l'utilisateur */
    $req = $bdd->prepare('SELECT * FROM utilisateur WHERE mail = ?');
    $req->execute(array($_POST['email']));
    $utilisateur = $req->fetch();
    // on teste si le mail existe
    if (!$utilisateur) {
        echo '<script type="text/javascript">                 
                    BSalert("Informations incorrectes !", "danger")
                </script>';
    } else {
        /* On teste si le mdp proposé correspond à celui enregistré et si celui-ci est bien renseigné */
        /* Cas où cela ne fonctionne pas */
        $mdp_hash = hash('sha256', $_POST['mdp']);
        if ($mdp_hash != $utilisateur['mdp']) {
            echo '<script type="text/javascript">                 
                    BSalert("Informations incorrectes !", "danger")
                </script>';
        } else {
            // on teste si l'utilisateur est vérifié
            if ($utilisateur['verified'] == 0) {
                echo '<script type="text/javascript">                 
                    BSalert("Vous devez d\'abord vérifier votre compte en cliquant sur le lien envoyé à l\'adresse fournie !", "danger")
                </script>';
                exit();
            } else {
                $_SESSION['id_utilisateur'] = $utilisateur['id_utilisateur'];
                $_SESSION['nom'] = $utilisateur['nom'];
                $_SESSION['prenom'] = $utilisateur['prenom'];
                $_SESSION['mail'] = $utilisateur['mail'];
                $_SESSION['phrase_secrete'] = $utilisateur['phrase_secrete'];
                $_SESSION['derniere_connexion'] = $utilisateur['derniere_connexion'];
                $_SESSION['connecte'] = true;
                $_SESSION['qualite'] = $utilisateur['statut'];
                $req = $bdd->prepare('UPDATE utilisateur SET derniere_connexion = NOW() WHERE mail = ?');
                $req->execute(array($_POST['email']));
                echo '<script type="text/javascript">                 
                    BSalert("Connexion réussie !", "success")
                </script>';
                // Mise à jour du nombre de visites
                $req = $bdd->prepare('SELECT nb_visites AS nb FROM stats');
                $req->execute();
                $nb_visites = $req->fetch()[0];
                $req = $bdd->prepare('DELETE FROM stats WHERE nb_visites = ?');
                $req->execute(array($nb_visites));
                $nb_visites++;
                $req = $bdd->prepare('INSERT INTO stats (nb_visites) VALUES(?)');
                $req->execute(array($nb_visites));
                echo '<script type="text/javascript">                 
                    alert($nb_visites, "success")
                </script>';
                header('Location: accueil.php');
                // or die();

                exit();
            }
        }
    }
}
  ?>

</div>


<?php include("footer.php") ?>