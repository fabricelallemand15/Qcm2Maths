<?php session_start();
require('config.php');
include("head.php");
include("header.php"); 


if (!isset($_POST['nom']) or !isset($_POST['prenom']) or !isset($_POST['mail']) or !isset($_POST['mdp']) or !isset($_POST['mdp2']) or $_POST['nom'] == NULL or $_POST['prenom'] == NULL or $_POST['mail'] == NULL or $_POST['mdp'] == NULL or $_POST['mdp2'] == NULL) {

    echo "Vous ne devriez pas être ici : <a href='index.php'>Retour</a>";
    die();
} 

// utilisation de PHPMailer pour l'envoi de mail
use PHPMailer\PHPMailer\PHPMailer;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

// paramétrage de PHPMailer
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = SMTP;               //Adresse IP ou DNS du serveur SMTP
$mail->Port = PORT;                          //Port TCP du serveur SMTP
$mail->SMTPAuth = 1;                        //Utiliser l'identification

if($mail->SMTPAuth){
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;               //Protocole de sécurisation des échanges avec le SMTP
   $mail->Username   =  USERNAME;   //Adresse email à utiliser
   $mail->Password   =  PASSWORD;         //Mot de passe de l'adresse email à utiliser
}
$mail->CharSet = 'UTF-8'; //Format d'encodage à utiliser pour les caractères
?>

<h2 class='titre-identification'>Créer un compte</h2>

<div id="liveAlertPlaceholder"></div> 

<script type="text/javascript" src="js/BSalert.js" ></script>

<?php 
// Si les champs sont vides, on ne fait rien
if (!isset($_POST['nom']) or !isset($_POST['prenom']) or !isset($_POST['mail']) or !isset($_POST['mdp']) or !isset($_POST['mdp2']) or $_POST['nom'] == NULL or $_POST['prenom'] == NULL or $_POST['mail'] == NULL or $_POST['mdp'] == NULL or $_POST['mdp2'] == NULL) {
    echo '<script type="text/javascript">                 
            BSalert("Données incomplètes ! Veuillez recommencer...", "danger")
        </script>
        <button class="w-100 btn btn-lg btn-primary" type="button" onclick="location.href = "index.php";">Retour</button>';
} else {
// Sinon, on vérifie que les mots de passe correspondent
if ($_POST['mdp'] == $_POST['mdp2']) {
    // On vérifie que l'adresse mail n'est pas déjà utilisée
    $req = $bdd->prepare('SELECT nom FROM utilisateur WHERE mail = ?');
    $req->execute(array($_POST['mail']));
    $result = $req->rowCount();
    // echo "adresse du formulaire : ".$_POST['mail'].'<br>';
    // echo "Résultat : ".$result.'<br>';
            if ($result>0) {
                echo '<script type="text/javascript">                 
                BSalert("Adresse mail déjà utilisée ! Veuillez recommencer... <br>Si vous avez oublié votre mot de passe cliquer sur le bouton `Mot de passe oublié`", "danger")
            </script>
            <button class="w-100 btn btn-lg btn-primary" type="button" onclick="location.href = `index.php`;">Retour</button>';
            } else {
                // On insère les données dans la base de données
                $req = $bdd->prepare('INSERT INTO utilisateur (nom, prenom, mail, mdp, phrase_secrete) VALUES (?, ?, ?, ?, ?)');
                $mdp_hash = hash('sha256', $_POST['mdp']);
                $rep = $req->execute(array($_POST['nom'], $_POST['prenom'], $_POST['mail'], $mdp_hash, $_POST['phrase']));
                // echo "Retour : ".$rep;
                echo '<script type="text/javascript">                 
                BSalert("Inscription réussie ! <br>Vous allez recevoir un courriel de confirmation. Cliquez sur le lien inclus dans ce courriel pour confirmer votre adresse.<br>Vous pourrez alors vous connecter...", "success")
                </script>
                <button class="w-100 btn btn-lg btn-primary" type="button" onclick="location.href = `index.php`;">Retour</button>';
                // On envoie un mail de confirmation
                // on cache l'adresse mail grâce à un hash
                $mail_hash = hash('sha256', $_POST['mail']);
                $mail->From       =  'maths@flallemand.fr';                //L'email à afficher pour l'envoi
                $mail->FromName   = 'Confirmation QcmEval';           //L'alias à afficher pour l'envoi
                $mail->AddAddress($_POST['mail']); //L'adresse à laquelle envoyer le mail
                $mail->Subject  = 'Confirmation d\'inscription'; //Le sujet du mail
                $mail->Body     = 'Bonjour '.$_POST['prenom'].',<br><br>
                Vous venez de vous inscrire sur l\'application QcmEval.<br>
                Pour confirmer votre adresse, cliquez sur le lien suivant : <a href='.PATH_TO_APP.'/confirm.php?mail='.$mail_hash.'>'.PATH_TO_APP.'/confirm.php?mail='.$mail_hash.'</a><br><br>
                Cordialement,<br><br>
                L\'équipe de l\'application QcmEval'; //Le contenu du mail
                $mail->IsHTML(true); //On envoie le mail au format HTML
                $mail->Send(); //On envoie le mail
                $mail->SmtpClose(); //On ferme la connexion SMTP
            }
    } else {

        echo '<script type="text/javascript">                 
                BSalert("Les mots de passe ne correspondent pas ! Veuillez recommencer...", "danger")
            </script>
            <button class="w-100 btn btn-lg btn-primary" type="button" onclick="location.href = `index.php`;">Retour</button>';
    }
}


include("footer.php") ?>