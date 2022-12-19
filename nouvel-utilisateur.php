<?php session_start();
require('config.php');
include("head.php");
include("header.php"); ?>

<h2 class='titre-identification'>Créer un compte</h2>

<p>
    Veuillez renseigner les informations suivantes afin de vous inscrire
</p>

<p>
    À l'issue de ce formulaire <b>un email de validation de l'inscription</b> vous sera envoyé sur votre boîte mail académique.
</p>

<p>Si vous ne possédez pas d'adresse académique, vous pouvez contacter l'administrateur du site à l'adresse suivante :</p>
<ul>
    <li>F. LALLEMAND : fabrice.lallemand (at) ac-clermont.fr</li>
</ul>

<fieldset class="form-group fieldset-identification">
    <legend>Informations personnelles</legend>
    <form id="form" method="post" action="check_new_user.php">
    
        <table cellspacing="0" cellpadding="5">
            <tr>
                <td class='auth_td auth_td_texte'>
                    Nom :
                </td>
                <td class='auth_td'>
                    <input type="text" name="nom" class="form_new_user" required />
                </td>
            </tr>
            <tr>
                <td class='auth_td auth_td_texte'>
                    Prénom :
                </td>
                <td class='auth_td'>
                    <input type="text" name="prenom" class="form_new_user" required />
                </td>
            </tr>
            <tr>
                <td class='auth_td auth_td_texte'>
                    Mail académique (...@ac-rectorat.fr):
                </td>
                <td class='auth_td'>
                    <input type="email" name="mail" pattern=".+@ac-(amiens\.fr|aix-marseille\.fr|besancon\.fr|bordeaux\.fr|caen\.fr|clermont\.fr|corse\.fr|creteil\.fr|dijon\.fr|douai\.fr|grenoble\.fr|guadeloupe\.fr|guyane\.fr|lille\.fr|limoge\.frs|lyon\.fr|martinique\.fr|mayotte\.fr|montpellier\.fr|nantes\.fr|nancy-metz\.fr|nice\.fr|noumea\.nc|orleans-tours\.fr|paris\.fr|poitiers\.fr|polynesie\.pf|reims\.fr|reunion\.fr|rennes\.fr|rouen\.fr|spm\.fr|strasbourg\.fr|toulouse\.fr|versailles\.fr|wf\.wf)" class="form_new_user" required />
                </td>
            </tr>
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
            <tr>
                <td class='auth_td auth_td_texte'>
                    Phrase secrète (permet de débloquer les élèves en mode anti-triche) :
                </td>
                <td class='auth_td'>
                    <input type="texte" name="phrase" class="form_new_user"/>
                </td>
            </tr>
        </table>
        <button class='btn btn-primary' type="submit">S'inscrire</button>
    </form>
</fieldset>



<?php include("footer.php") ?>