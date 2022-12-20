<?php session_start();
require('config.php');
include("head.php");
include("header.php"); 

// confirmation de l'adresse mail du nouvel inscrit
?>

<br>
<div id="liveAlertPlaceholder"></div> 

<script type="text/javascript" src="js/BSalert.js" ></script>

<?php
$mail_hash = $_GET['mail'];
// on lit tous les mails dans la base de données
$req = $bdd->prepare('SELECT * FROM utilisateur');
$req->execute();
$result = $req->fetchAll();
// on vérifie que l'adresse mail est bien dans la base de données
$present = false;
foreach ($result as $row) {
    if (hash('sha256', $row['mail']) == $mail_hash) {
        $req = $bdd->prepare('UPDATE utilisateur SET verified = 1 WHERE mail = ?');
        $req->execute(array($row['mail']));
        echo '<script type="text/javascript">                 
                BSalert("Votre adresse mail a bien été confirmée ! Vous pouvez maintenant vous connecter.", "success")
            </script>
            <button class="w-100 btn btn-lg btn-primary" type="button" onclick="location.href = `index.php`;">Connexion</button>';
        $present = true;
    } 
}
if (!$present){
    echo '<script type="text/javascript">                 
                BSalert("Votre adresse mail n\'a pas été confirmée ! Veuillez recommencer...", "danger")
            </script>
            <button class="w-100 btn btn-lg btn-primary" type="button" onclick="location.href = `index.php`;">Retour</button>';
}

include("footer.php") ?>