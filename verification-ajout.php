<?php session_start();
include("config.php");
include("head.php");


if (empty($_SESSION) or $_SESSION['connecte'] != true) {
    include("header.php");
    echo "Vous ne devriez pas être ici : <a href='index.php'>Retour</a>";} else {
    include("header.php");
    include("nav.php");

    // On détermine les attributs de la question
    $texte = $_POST['question'];
    // echo "Texte : " . $texte . "<br>";
    $reponseA = $_POST['reponseA'];
    // echo "Reponse A : " . $reponseA . "<br>";
    $reponseB = $_POST['reponseB'];
    // echo "Reponse B : " . $reponseB . "<br>";
    $reponseC = $_POST['reponseC'];
    // echo "Reponse C : " . $reponseC . "<br>";
    $reponseD = $_POST['reponseD'];
    // echo "Reponse D : " . $reponseD . "<br>";
    $bonne_reponse = $_POST['bonne_reponse'];
    // echo "Bonne reponse : " . $bonne_reponse . "<br>";
    $fichier_image = $_FILES['file']['name'];
    // echo "Image : " . $fichier_image . "<br>";
    // echo "Retour post : ".$_POST['num_domaine_sous_domaine']."<br>";
    $selection_domaine = explode('-', $_POST['num_domaine_sous_domaine']);
    $niveau = $selection_domaine[0];
    echo "Niveau : ".$niveau."<br>";
    $domaine = $selection_domaine[1];
    echo "Domaine : ".$domaine."<br>";
    $sous_domaine = "";
    if (isset($selection_domaine[2])) {
        $sous_domaine = $selection_domaine[2];
    }
    echo "Sous domaine : ".$sous_domaine."<br>";
    // on récupère id_niveau de niveau dans la base
    $req_niveau = $bdd->prepare("SELECT id_niveau FROM niveau WHERE nom = ?");
    $req_niveau->execute(array($niveau));
    $id_niveau = $req_niveau->fetch()[0];
    echo "le id-niveau est : " . $id_niveau . "<br>";
    // on récupère id_domaine de domaine dans la base
    $req_domaine = $bdd->prepare("SELECT id_domaine FROM domaine WHERE nom = ? AND id_niveau = ?");
    $req_domaine->execute(array($domaine, $id_niveau));
    $id_domaine = $req_domaine->fetch()[0];
    // afficher le résultat de la requête
    echo "id_domaine : ".$id_domaine."<br>";
    // on récupère id_sous_domaine de sous_domaine dans la base
    if ($sous_domaine != "") {
        $req_sous_domaine = $bdd->prepare("SELECT id_sous_domaine FROM sous_domaine WHERE nom = ? AND id_domaine = ?");
        $req_sous_domaine->execute(array($sous_domaine, $id_domaine));
        $id_sous_domaine = $req_sous_domaine->fetch()[0];
        // afficher le résultat de la requête
        echo "id_sous_domaine : ".$id_sous_domaine."<br>";
    }
    // on récupère id_auteur de utilisateur
    $id_auteur = $_SESSION['id_utilisateur'];
    
    // on ajoute les informations dans la base
    $req_ajout = $bdd->prepare("INSERT INTO question (texte, reponseA, reponseB, reponseC, reponseD, bonne_reponse, id_auteur, id_domaine, id_sous_domaine, id_niveau, nom_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $rep = $req_ajout->execute(
        array(
            $texte,
            $reponseA,
            $reponseB,
            $reponseC,
            $reponseD,
            $bonne_reponse,
            $id_auteur,
            $id_domaine,
            $id_sous_domaine,
            $id_niveau,
            $fichier_image
        )
    );
    if ($rep) {
        echo "Insertion faite !"."<br>";
    } else {
        echo "Erreur d'insertion !"."<br>";
    }
    // vérification du type de toutes les variables de la requête
    echo "Type de texte : ".gettype($texte)."<br>";
    echo "Type de reponseA : ".gettype($reponseA)."<br>";
    echo "Type de reponseB : ".gettype($reponseB)."<br>";
    echo "Type de reponseC : ".gettype($reponseC)."<br>";
    echo "Type de reponseD : ".gettype($reponseD)."<br>";
    echo "Type de bonne_reponse : ".gettype($bonne_reponse)."<br>";
    echo "Type de id_auteur : ".gettype($id_auteur)."<br>";
    echo "Type de id_domaine : ".gettype($id_domaine)."<br>";
    echo "Type de id_sous_domaine : ".gettype($id_sous_domaine)."<br>";
    echo "Type de id_niveau : ".gettype($id_niveau)."<br>";
    echo "Type de fichier_image : ".gettype($fichier_image)."<br>";
    


    $statut = "";
    /* Récupération du numéro de la question pour nommer l'image*/
    $req_id = $bdd->prepare("SELECT id_question FROM question WHERE id_auteur = ? ORDER BY date_ajout DESC LIMIT 1");
    $req_id->execute(array($_SESSION['id_utilisateur']));

    $id = $req_id->fetch();

    /* Chargement de l'image si son nom est non vide */
    if ($_FILES['file']['name'] != "") {

        $filename = $id['id_question'] . "_" . $_FILES['file']['name'];

        /* Emplacement du fichier */
        $location = "image_questions/" . $filename;
        $imageFileType = pathinfo($location, PATHINFO_EXTENSION);

        /* Confirmation du type d'image */
        $valid_extensions = array("jpg", "jpeg", "png", "gif");

        if (!in_array(strtolower($imageFileType), $valid_extensions)) {
            $statut = "erreur_format";
        } else if ($_FILES['file']['size'] > 300000) {
            $statut = 'erreur_taille';
        } else if (strlen($filename) > 50) {
            $statut = 'erreur_nom';
        } else {
            /* Chargement de l'image */
            if (move_uploaded_file($_FILES['file']['tmp_name'], $location)) {
                $statut = 'success';
                $sql = "UPDATE questions SET image = '" . $filename . "' WHERE num_question = " . $id['num_question'];
                $update_img = $bdd->prepare($sql);
                $update_img->execute();
            } else {
                $statut = 'erreur_chargement';
            }
        }
        //echo $statut;
    }

?>

    <h1 class='h1-qcm'>Confirmation de l'ajout</h1>

    <p>Votre question a été ajoutée dans la base à la référence #<?= $id['id_question'] ?></p>

    <?php
    if ($statut == 'erreur_format') {
        echo "<p>Par contre le format de l'image était incorrect<p>";
    } else if ($statut == 'erreur_taille') {
        echo "<p>Par contre l'image était trop lourde<p>";
    } else if ($statut == 'erreur_chargement') {
        echo "<p>Par contre il y a eu un problème lors du chargement de l'image<p>";
    } else if ($statut == 'erreur_nom') {
        echo "<p>Par contre le nom de l'image était trop long. Il faut la renommer<p>";
    }
    ?>

<?php
    $req_domaine = $bdd->prepare("SELECT domaine FROM domaines WHERE num_domaine = " . $dom_ss_dom[0]);
    $req_domaine->execute();
    $domaine = $req_domaine->fetch();

    $req_sous_domaine = $bdd->prepare("SELECT sous_domaine FROM sous_domaines WHERE num_sous_domaine = " . $dom_ss_dom[1]);
    $req_sous_domaine->execute();
    $sous_domaine = $req_sous_domaine->fetch();
?>

    <p>Elle fait partie du domaine "<b><?= $domaine['domaine'] ?></b>" et du sous-domaine "<b><?= $sous_domaine['sous_domaine'] ?></b>" </p>

  

    <p>Voici son rendu :</p>
    <div class='div-rendu'>
        <?php
    $numero_q = 1;

    $req_q = $bdd->prepare("SELECT * FROM questions WHERE num_question = ?");
    $req_q->execute(array($id['num_question']));

    $question = $req_q->fetch();
        ?>
        <div>
            <?= $question['question'] ?>
        </div>
        <?php

    if (!is_null($question['image'])):
        ?>

            <img class='img-question' src="image_questions/<?= $question['image'] ?>">

        <?php endif; ?>

        <div class='input-group reponse-selection-<?php if ($question['bonne_reponse'] == 'A'):
        echo 'bonne'; else:
        echo "mauvaise";
    endif; ?>'>
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="radio" disabled>
                </div>
            </div>
            <span class='form-control'><?= $question['reponseA'] ?></span>
        </div>
       
        <br>
        <br>

        <div class='input-group reponse-selection-<?php if ($question['bonne_reponse'] == 'B'):
        echo 'bonne'; else:
        echo "mauvaise";
    endif; ?>'>
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="radio" disabled>
                </div>
            </div>
            <span class='form-control'><?= $question['reponseB'] ?></span>
        </div>

        <br>

        <div class='input-group reponse-selection-<?php if ($question['bonne_reponse'] == 'C'):
        echo 'bonne'; else:
        echo "mauvaise";
    endif; ?>'>
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="radio" disabled>
                </div>
            </div>
            <span class='form-control'><?= $question['reponseC'] ?></span>
        </div>

        <br>

        <div class='input-group reponse-selection-<?php if ($question['bonne_reponse'] == 'D'):
        echo 'bonne'; else:
        echo "mauvaise";
    endif; ?>'>
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="radio" disabled>
                </div>
            </div>
            <span class='form-control'><?= $question['reponseD'] ?></span>
        </div>

        <br>

        <div class='input-group reponse-selection-mauvaise'>
            <div class="input-group-prepend">
                <div class="input-group-text">
                    <input type="radio" disabled checked>
                </div>
            </div>
            <span class='form-control'>Je ne sais pas...</span>
        </div>

        <br>
    </div>
    <p>Cliquer ci-dessous pour la modifier</p>
    <form method="post" action="modif-question.php">
        <input type="hidden" name="num_question" value="<?= $id['num_question'] ?>">
        <button class='btn btn-info'>Modifier cette question</button>
    </form>

    <p>Cliquer ci-dessous pour effectuer un nouvel ajout</p>

    <form method="post" action="ajout.php">
        <button class='btn btn-info'>Nouvel Ajout</button>
    </form>

<?php
}
include("footer.php")
?>

</body>

<script>
    $("document").ready(function() {
        render_md_math();
    })
</script>

</html>