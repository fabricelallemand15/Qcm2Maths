<?php session_start();
require('config.php');
include("head.php");
include("header.php") ?>

<h2 class='titre-identification'>Mot de passe oublié</h2>

<p>Pour des raisons de sécurité, votre mot de passe n'est pas enregistré dans la base, il n'est donc pas récupérable. Vous pouvez néanmoins le modifier en suivant les étapes ci-dessous.</p> 

<p>
    Merci de compléter les informations ci-dessous afin de vérifier votre identité. Vous recevrez un mail contenant un lien permettant de modifier votre mot de passe.
</p>

<fieldset class="form-group fieldset-identification">
    <legend>Informations de récupération</legend>
    <form id="form" method="post" action="send_mail_new_pwd.php">

        <div class="mb-3" id="form_change_pwd">
            <label for="mail" class="form-label">Email utilisé lors de l'inscription</label>
            <input type="email" class="form-control" name="mail" id="mail" placeholder="jenaipasdetete@ane.com" required>
        </div>

        <button class='btn btn-danger' type="submit">Confirmer la demande de modification de mot de passe</button>
    </form>
</fieldset>

<?php include("footer.php") ?>