<?php session_start();
require('config.php');
include("head.php");
include("header.php"); 

if (!isset($_GET['mail']) or $_GET['mail'] == NULL) {

    echo "Vous ne devriez pas être ici : <a href='index.php'>Retour</a>";
    die();
} 
?>

<h2 class='titre-identification'>Définir un nouveau mot de passe</h2>

<p>
    Veuillez entrer votre nouveau mot de passe dans le formulaire ci-dessous.
</p>

<fieldset class="form-group fieldset-identification">
    <legend>Nouveau mot de passe</legend>
    <form id="form" method="post" action="def_new_pwd.php">
    
        <table cellspacing="0" cellpadding="5">
            <tr>
                <td class='auth_td auth_td_texte'>
                    Mot de passe :
                </td>
                <td class='auth_td'>
                    <input type="password" name="mdp" autocomplete="new-password" class="form_new_user" required />
                </td>
            </tr>
            <tr>
                <td class='auth_td auth_td_texte'>
                    Confirmation du mot de passe :
                </td>
                <td class='auth_td'>
                    <input type="password" name="mdp2" autocomplete="new-password" class="form_new_user" required />
                </td>
            </tr>
        </table>
        <input type="hidden" name="mail_hash" value="<?php echo $_GET['mail'] ?>" />
        <button class='btn btn-primary' type="submit">Confirmer</button>
    </form>
</fieldset>


<?php include("footer.php") ?>