<?php session_start();
include("config.php");
include("head.php");

if (empty($_SESSION) or $_SESSION['connecte'] != true) :
    include("header.php");
    echo "Vous ne devriez pas être ici : <a href='index.php'>Retour</a>";
else :
    include("header.php");
    include("nav.php"); ?>

<div id="liveAlertPlaceholder"></div>

<?php

if (!isset($_POST['id_question']) or is_null($_POST['id_question'])) {

    echo '<p>Vous n\'avez pas fourni toutes les infos</p>';
} else {
    // on récupère le nom de l'image de la question
    $req = $bdd->prepare('SELECT nom_image FROM question WHERE id_question = ?');
    $req->execute(array($_POST['id_question']));
    $image = $req->fetch();
    $req->closeCursor();
    // on supprime le fichier image si il existe
    if ($image[0]!='') {
    if (file_exists('images/'.$image[0])) {
        unlink('images/'.$image[0]);
    }}
    
    
    $req = $bdd->prepare('DELETE FROM question WHERE id_question = ?');
    $req->execute(array($_POST['id_question']));
    $req->closeCursor();

    echo '<script type="text/javascript">                 
            BSalert("Question #'.$_POST['id_question'].' supprimée !", "success");
          </script>';
}

endif;
?>

<?php include("footer.php") ?>