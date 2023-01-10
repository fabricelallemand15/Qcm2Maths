<?php session_start();
require('config.php');
include("head.php");
include("header.php"); 

// echo $_POST['mail'];

if (!isset($_POST['mail']) or $_POST['mail'] == NULL) {

    echo "Vous ne devriez pas être ici : <a href='index.php'>Retour</a>";
    die();
} 

// utilisation de PHPMailer pour l'envoi de mail

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


<h2 class='titre-identification'>Modification du mot de passe</h2>

<div id="liveAlertPlaceholder"></div> 

<?php

// vérification de l'existence de l'adresse mail dans la base
$requete = $bdd->prepare('SELECT * FROM utilisateur WHERE mail = ?');
$requete->execute(array($_POST['mail']));
$donnees = $requete->fetch();

if ($donnees == NULL) {
    echo '<script type="text/javascript">                 
                    BSalert("Cette adresse mail n\'est pas enregistrée dans la base", "danger")
                </script>';
    echo "<a href='forget_pwd.php'>Retour</a>";
    include("footer.php");
    die();
} else {
    //envoi d'un mail de changement de mot de passe
    // on cache l'adresse mail grâce à un hash
    $mail_hash = hash('sha256', $_POST['mail']);
    $mail->From       =  'maths@flallemand.fr';                //L'email à afficher pour l'envoi
    $mail->FromName   = 'Confirmation QcmEval';           //L'alias à afficher pour l'envoi
    $mail->AddAddress($_POST['mail']); //L'adresse à laquelle envoyer le mail
    $mail->Subject  = 'Mot de passe oublié'; //Le sujet du mail
    $mail->Body     = 'Bonjour '.$donnees['prenom'].',<br><br>
    Vous avez demandé la réinitialisation de votre mot de passe sur l\'application QcmEval.<br>
    Pour confirmer et définir un nouveau mot de passe, cliquez sur le lien suivant : <a href='.PATH_TO_APP.'/new_pwd.php?mail='.$mail_hash.'>'.PATH_TO_APP.'/new_pwd.php?mail='.$mail_hash.'</a><br><br>
    Si vous n\'êtes pas à l\'origine de cette demande, ignorez ce mail.<br><br> 
    Cordialement,<br><br>
    L\'équipe de l\'application QcmEval'; //Le contenu du mail
    $mail->IsHTML(true); //On envoie le mail au format HTML
    $mail->Send(); //On envoie le mail
    $mail->SmtpClose(); //On ferme la connexion SMTP
    echo '<script type="text/javascript">                 
                    BSalert("Un courriel a été envoyé à l\'adresse indiquée. Suivre les instructions contenues dans ce message pour réinitialiser le mot de passe.", "success")
                </script>';
    echo "<a href='forget_pwd.php'>Retour</a>";
}

include("footer.php"); ?>