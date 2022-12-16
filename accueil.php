<?php 
session_start();
include("config.php");
include("head.php");
?>

<body>
<?php
if (empty($_SESSION) or $_SESSION['connecte'] != true) {
    include("header.php");
    echo "Vous ne devriez pas être ici : <a href='index.php'>Retour</a>";
    die();
} else {
    include("header.php");
    include("nav.php");
}
?>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1>Accueil</h1>
                <p>Bienvenue sur Qcm2Maths</p>
            </div>
        </div>
    </div>

<?php include("footer.php"); ?>