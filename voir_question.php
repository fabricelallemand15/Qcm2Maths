<?php session_start();
include("config.php");
include("head.php");

if (empty($_SESSION) or $_SESSION['connecte'] != true) :
    include("header.php");
    echo "Vous ne devriez pas être ici : <a href='index.php'>Retour</a>";
else :
    include("header.php");
    include("nav.php");
    $id_question = $_POST['id_question'];
    afficher_question($id_question, "avec_reponses");
    ?>

    <p>
        <button id='btn-retour' class='btn btn-primary' type='button' onclick="location.href = 'gestion.php';">Retour</button>
    </p>
<?php
endif;
?>

<?php include("footer.php") ?>