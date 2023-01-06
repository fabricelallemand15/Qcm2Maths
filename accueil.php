<?php 
session_start();
include("config.php");
include("head.php");
?>

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
    <div class="contenu-principal">
        <div class="row">
            <div class="col-12">
                <h1 class="titre">Accueil</h1>
                <p class="titre">Bienvenue sur QcmEval</p>
            </div>
        </div>

    <p>Cette application permet de générer des QCM de Mathématiques en choisissant les questions dans une base de données collaborative.</p>

    <p>L'un des objectifs du site est de centraliser les questions de tous les collègues qui le souhaitent.</p>

    <p>Alors n'hésitez pas à <a href="ajout.php" style='font-weight:bold;color:purple;'>contribuer</a> et à ajouter des questions !</p>

    <p>
        Vous pouvez donc :
    </p>
    <div class="container text-center">
        <div class="row align-items-start">
            <div class="col">
                <p><strong>Créer des qcm pour vos élèves</strong></p>
                <p><a class="link" href="selection-manuelle.php">Par sélection manuelle</a></p>
            </div>
            <div class="col">
                <p><strong>Consulter les résultats de vos élèves</strong></p>
                <p><a class="link" href="resultats.php">Résultats</a></p>
            </div>
            <div class="col">
                <strong>Ajouter, modifier ou exporter des questions de la base</strong>
                <ul class="navbar-nav mr-auto">
                    <li><a class="link" href="ajout.php">Ajout</a></li>
                    <li><a class="link" href="modification.php">Modification</a></li>
                    <li><a class="link" href="exports.php">Export</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div id="fil">
    <p>A ce jour, QcmEval c'est :</p>
    <table id="summary" class="table table-striped table-hover table-primary table-bordered">
        <?php
            $req = $bdd->prepare("SELECT nb_visites AS nb FROM stats");
            $req->execute();
            $r = $req->fetch();
            ?>
        <tr>
            <td>Nombre de visite depuis l'ouverture du site</td>
            <td><?= $r['nb'] ?></td>
        </tr>

        <?php
            $req = $bdd->prepare("SELECT count(*) AS nb FROM utilisateur WHERE 1");
            $req->execute();
            $r = $req->fetch();
            ?>
        <tr>
            <td>Nombre d'utilisateurs dans la base</td>
            <td><?= $r['nb'] ?></td>
        </tr>

        <?php
            $req = $bdd->prepare("SELECT count(*) AS nb FROM question WHERE 1");
            $req->execute();
            $r = $req->fetch();
            ?>
        <tr>
            <td>Nombre de questions dans la base</td>
            <td><?= $r['nb'] ?></td>
        </tr>

        <?php
            $req = $bdd->prepare("SELECT count(*) AS nb FROM qcm WHERE 1");
            $req->execute();
            $r = $req->fetch();
            ?>
        <tr>
            <td>Nombre de qcms générés</td>
            <td><?= $r['nb'] ?></td>
        </tr>

        <?php
            $req = $bdd->prepare("SELECT count(*) AS nb FROM question JOIN niveau ON question.id_niveau = niveau.id_niveau WHERE niveau.nom = 'Seconde'");
            $req->execute();
            $r = $req->fetch();
            ?>
        <tr>
            <td>Nombre de questions de Seconde dans la base</td>
            <td><?= $r['nb'] ?></td>
        </tr>

        <?php
            $req = $bdd->prepare("SELECT count(*) AS nb FROM question JOIN niveau ON question.id_niveau = niveau.id_niveau WHERE niveau.nom = 'Première'");
            $req->execute();
            $r = $req->fetch();
            ?>
        <tr>
            <td>Nombre de questions de Première dans la base</td>
            <td><?= $r['nb'] ?></td>
        </tr>

        <?php
            $req = $bdd->prepare("SELECT count(*) AS nb FROM question JOIN niveau ON question.id_niveau = niveau.id_niveau WHERE niveau.nom = 'Terminale'");
            $req->execute();
            $r = $req->fetch();
            ?>
        <tr>
            <td>Nombre de questions de Terminale dans la base</td>
            <td><?= $r['nb'] ?></td>
        </tr>

        <?php
            $req = $bdd->prepare("SELECT COUNT(*) as nb FROM question WHERE date_creation BETWEEN DATE_SUB(NOW(), INTERVAL 8 DAY) AND NOW()");
            $req->execute();
            $r = $req->fetch();
            ?>
        <tr>
            <td>Nombre de questions ajoutées depuis une semaine</td>
            <td><?= $r['nb'] ?></td>
        </tr>

        <?php
            $req = $bdd->prepare("SELECT COUNT(*) as nb FROM question WHERE date_creation BETWEEN DATE_SUB(NOW(), INTERVAL 32 DAY) AND NOW()");
            $req->execute();
            $r = $req->fetch();
            ?>
        <tr>
            <td>Nombre de questions ajoutées depuis un mois</td>
            <td><?= $r['nb'] ?></td>
        </tr>

    </table>
    </div>
    </div>

<?php

?>

<?php include("footer.php"); ?>