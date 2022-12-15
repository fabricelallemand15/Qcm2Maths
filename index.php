<?php 
include("head.php");
require('config.php');
session_start();
?>

<body id="login">
<h2>Bienvenue sur MathsQcmApp</h2>
<div>
    <form id="form_login" action="" method="post">
            <img class="mb-4" src="images/logo_qcm2maths.png" alt="logo" width="72">
            <h1 class="h3 mb-3 fw-normal">Authentification</h1>
            <div class="d-grid gap-2">
                <input type="email" name="email" id="email" placeholder="Email" required/>
                <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required/>
                <button class="w-100 btn btn-lg btn-success" type="submit">Valider</button>
                <button class='w-100 btn btn-lg btn-primary' type="button" onclick="">Nouvel utilisateur ?</button>
                <button class='w-100 btn btn-lg btn-warning' type="button" onclick="">Mot de passe oublié ?</button>
                <div id="liveAlertPlaceholder"></div>   
            </div>
            
    </form>
</div>

<?php
// TODO rediriger la page en cas de connexion réussie
if (!isset($_POST['mdp']) or !isset($_POST['email']) or $_POST['mdp'] == NULL or $_POST['email'] == NULL) {

    echo 'Vous n\'avez pas fourni toutes les infos';
} else {

    /* Récupération des infos de l'utilisateur */
    $req = $bdd->prepare('SELECT * FROM utilisateurs WHERE mail = ?');
    $req->execute(array($_POST['email']));
    $utilisateur = $req->fetch();

    /* Code javascript pour afficher le message d'erreur ou de succès */
    echo '<script type="text/javascript">
                      const alertPlaceholder = document.getElementById("liveAlertPlaceholder")
                      const alert = (message, type) => {
                            const wrapper = document.createElement("div")
                            wrapper.innerHTML = [
                                `<div class="alert alert-${type} alert-dismissible" role="alert">`,
                                `<div>${message}</div>`,
                                `<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`,
                                `</div>`
                            ].join("")
                        alertPlaceholder.append(wrapper)}
                </script>';

    /* On teste si le mdp proposé correspond à celui enregistré et si celui-ci est bien renseigné */
    /* Cas où cela ne fonctionne pas */
    $mdp_hash = hash('sha256', $_POST['mdp']);
    if ($mdp_hash != $utilisateur['mdp']) {
        echo '<script type="text/javascript">                 
                    alert("Informations incorrectes !", "danger")
                </script>';
    } else {
        $_SESSION['id_utilisateur'] = $utilisateur['id_utilisateur'];
        $_SESSION['nom'] = $utilisateur['nom'];
        $_SESSION['prenom'] = $utilisateur['prenom'];
        $_SESSION['mail'] = $utilisateur['mail'];
        $_SESSION['phrase_secrete'] = $utilisateur['phrase_secrete'];
        $_SESSION['avatar'] = $utilisateur['avatar'];
        $_SESSION['derniere_connexion'] = $utilisateur['derniere_connexion'];
        $_SESSION['connecte'] = true;
        $req = $bdd->prepare('UPDATE utilisateurs SET derniere_connexion = NOW() WHERE mail = ?');
        $req->execute(array($_POST['email']));
        echo '<script type="text/javascript">                 
                    alert("Connexion réussie !", "success")
                </script>';
    }
}
  ?>


<?php include("footer.php") ?>