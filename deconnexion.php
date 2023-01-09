<?php
session_start();
include("config.php");
include("head.php");

if (empty($_SESSION) or $_SESSION['connecte'] != true) :
    include("header.php");
    echo "Vous ne devriez pas être ici : <a href='index.php'>Retour</a>";
else :
    include("header.php");
    ?>

    <h4>
        Vous êtes déconnecté
    </h4>

    <a href="index.php">Identification</a>

<?php
session_destroy();
endif;
?>