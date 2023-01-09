<?php session_start();
include("config.php");
include("head.php");?>

    <?php

if (empty($_SESSION) or $_SESSION['connecte'] != true){
    include("header.php");
    echo "Vous ne devriez pas être ici : <a href='index.php'>Retour</a>";
    } else {
        include("header.php");
        include("nav.php");
        // on crée la liste des niveaux
        $req_niveaux = $bdd->prepare("SELECT * FROM niveau");
        $req_niveaux->execute();
        $niveaux = $req_niveaux->fetchAll();
        // on crée la liste des domaines
        $req_domaines = $bdd->prepare("SELECT niveau.nom AS nom_niveau, domaine.nom as nom_dom FROM domaine JOIN niveau ON domaine.id_niveau = niveau.id_niveau");
        $req_domaines->execute();
        $domaines = $req_domaines->fetchAll();
        // on récupère les sous-domaines
        $req_sous_domaines = $bdd->prepare("SELECT niveau.nom AS niv, domaine.nom AS nom_dom, sous_domaine.nom AS nom_sous_dom FROM sous_domaine JOIN domaine ON domaine.id_domaine = sous_domaine.id_domaine JOIN niveau on domaine.id_niveau = niveau.id_niveau");
        $req_sous_domaines->execute();
        $sous_domaines = $req_sous_domaines->fetchAll();
        // construction d'un tableau associatif nommé DOMAINES de tableaux associatifs par niveaux, domaines, puis sous-domaines
        $DOMAINES = array();
        foreach ($niveaux as $niveau) {
            $DOMAINES[$niveau['nom']] = array();
        }
        foreach ($domaines as $domaine) {
            $DOMAINES[$domaine['nom_niveau']][$domaine['nom_dom']] = array();
        }
        foreach ($sous_domaines as $sous_domaine) {
            array_push($DOMAINES[$sous_domaine['niv']][$sous_domaine['nom_dom']],$sous_domaine['nom_sous_dom']);
        }
 ?>	

 <!-- Texte et consignes -->

    <div class="contenu-principal">

    <h1 class='titre'>Modification de la question <?php echo '#'.$_POST['id_question']?></h1>

    <p>Vous pouvez ici modifier une question. Il suffit de compléter tous les champs proposés.</p>

    <p>Pour mettre en forme votre texte, vous devez utiliser la syntaxe Markdown, en laissant une ligne vide entre chaque paragraphe.</p>
    <p>Les formules mathématiques seront entrées en $\LaTeX$, encadrées du symbole "\$" pour une équation en ligne et du symbole "\$\$" pour une équation hors ligne centrée.</p>

    <p>Le code Python sera délimité par "~~~~python" et "~~~~".</p>

    <p>Pour en savoir plus, vous pouvez <a href="aide.php">consulter la documentation</a>.</p>

    <p>Il est possible d'insérer une image dans la question. Celle-ci sera toujours centrée et placée entre le texte de la question et les réponses.</p>

    <p style="color:red;">La version modifiée écrasera la version précédente de la question.</p>

    <p>Le bouton jaune "Prévisualiser la question" permet de vérifier votre saisie avant d'insérer la question dans la base.</p>

</div>

<?php
// on récupère l'id de la question à modifier
$id_question = $_POST['id_question'];
// on récupère les infos de la question à modifier
$req_question = $bdd->prepare("SELECT * FROM question WHERE id_question = ?");
$req_question->execute(array($id_question));
$question = $req_question->fetch();
?>

<!-- Début du formulaire d'ajout -->
<form id='formulaire-ajout' method='post' action='verification_modif.php' enctype="multipart/form-data">

<!-- Texte de la question -->
<section class='saisie alert alert-warning'>
<p class='instruction'>Saisir ci-dessous la question en utilisant la syntaxe Markdown</p>
<textarea rows="20" cols="50" id='inp-question' class='inp form-control' name="question" form_id='formulaire-ajout'">
<?php echo $question['texte']; ?>
</textarea>
</section>

<!-- Image associée à la question -->
<section class='saisie  alert alert-warning'>
<p class='instruction'>Charger une image (si besoin)</p>
<p class='instruction'>Seuls les formats jpg, jpeg et png sont acceptés. Le fichier doit faire moins de 500 ko.</p>
<p class='instruction'>Pour conserver l'image actuelle (la cas échéant), vous devez la charger à nouveau. Pour remplacer l'image actuelle par un autre image, utiliser le bouton "Parcourir" ci-dessous. Pour supprimer l'image sans la remplacer, il suffit d'ignorer cette étape.</p>
<!-- input pour charger un fichier de type .jpg .jpeg ou .png de 500ko maximum -->
<div class="input-group mb-3">
<div class="custom-file">
    <?php     
    $file = $question['nom_image'];
    if ($file != '') {
        echo '<p class="instruction">Image actuelle : ' . $file . ' <b><i class="bi bi-exclamation-triangle-fill"></i>Image à recharger si vous voulez la conserver !</b></p>';
        echo '<img id="image-modif" src="images/' . $file . '" alt="image de la question">';
    }
    echo '<input type="file" accept="image/jpeg, image/png" max="500000" class="form-control" type="file" name="file" id="file"  ">';
    ?>
    <!-- bouton pour remettre à vide la valeur de id=file -->
<div class="input-group-append" id="bouton_efface">
    <button class="btn btn-danger" type="button" onclick="effaceImage()">Effacer</button>
</div>
</div>
</section>

<!-- Saisie de la réponse A -->
<section class='saisie alert alert-warning'>
<p class='instruction'>Saisir ci-dessous le texte de votre réponse A</p>
<textarea rows="10" cols="50" id='inp-repA' class='inp-rep form-control' name="reponseA" form_id='formulaire-ajout'">
<?php echo $question['reponseA']; ?>
</textarea>
</section>

<!-- Saisie de la réponse B -->
<section class='saisie  alert alert-warning'>
<p class='instruction'>Saisir ci-dessous le texte de votre réponse B</p>
<textarea rows="10" cols="50" id='inp-repB' class='inp-rep form-control' name="reponseB" form_id='formulaire-ajout'">
<?php echo $question['reponseB']; ?>
</textarea>
</section>

<!-- Saisie de la réponse C -->
<section class='saisie  alert alert-warning'>
<p class='instruction'>Saisir ci-dessous le texte de votre réponse C</p>
<textarea rows="10" cols="50" id='inp-repC' class='inp-rep form-control' name="reponseC" form_id='formulaire-ajout'">
<?php echo $question['reponseC']; ?>
</textarea>
</section>

<!-- Saisie de la réponse D -->
<section class='saisie  alert alert-warning'>
<p class='instruction'>Saisir ci-dessous le texte de votre réponse D</p>
<textarea rows="10" cols="50" id='inp-repD' class='inp-rep form-control' name="reponseD" form_id='formulaire-ajout' ">
<?php echo $question['reponseD']; ?>
</textarea>
</section>

<!-- Choix de la bonne réponse -->
<section class='saisie alert alert-warning'>
<p class='instruction'>Indiquer quelle est la bonne réponse</p>
<select name="bonne_reponse" class="form-select" required>
    <?php
    $bonne_reponse = $question['bonne_reponse'];
    switch($bonne_reponse){
        case 'A':
            echo '<option value="A" id="rep_A_g" selected>A</option>';
            echo '<option value="B" id="rep_B_g">B</option>';
            echo '<option value="C" id="rep_C_g">C</option>';
            echo '<option value="D" id="rep_D_g">D</option>';
            break;
        case 'B':
            echo '<option value="A" id="rep_A_g">A</option>';
            echo '<option value="B" id="rep_B_g" selected>B</option>';
            echo '<option value="C" id="rep_C_g">C</option>';
            echo '<option value="D" id="rep_D_g">D</option>';
            break;
        case 'C':
            echo '<option value="A" id="rep_A_g">A</option>';
            echo '<option value="B" id="rep_B_g">B</option>';
            echo '<option value="C" id="rep_C_g" selected>C</option>';
            echo '<option value="D" id="rep_D_g">D</option>';
            break;
        case 'D':
            echo '<option value="A" id="rep_A_g">A</option>';
            echo '<option value="B" id="rep_B_g">B</option>';
            echo '<option value="C" id="rep_C_g">C</option>';
            echo '<option value="D" id="rep_D_g" selected>D</option>';
            break;
    }
    ?>
</select>
</section>
<?php
$id_niveau = $question['id_niveau'];
$id_domaine = $question['id_domaine'];
$id_sous_domaine = $question['id_sous_domaine'];
// on récupère le nom du niveau, du domaine et du sous domaine en interrogant la base de données
$nom_niveau = $bdd->prepare("SELECT nom FROM niveau WHERE id_niveau = ?");
$nom_niveau->execute(array($id_niveau));
$nom_niveau = $nom_niveau->fetch();
$nom_niveau = $nom_niveau[0];
$nom_domaine = $bdd->prepare("SELECT nom FROM domaine WHERE id_domaine = ?");
$nom_domaine->execute(array($id_domaine));
$nom_domaine = $nom_domaine->fetch();
$nom_domaine = $nom_domaine[0];
$nom_sous_domaine = $bdd->prepare("SELECT nom FROM sous_domaine WHERE id_sous_domaine = ?");
$nom_sous_domaine->execute(array($id_sous_domaine));
$nom_sous_domaine = $nom_sous_domaine->fetch();
if ($nom_sous_domaine == false) {
    $nom_sous_domaine = "NULL";
} else {
    $nom_sous_domaine = $nom_sous_domaine[0];
}
$niv_dom_sd = $nom_niveau . "-" . $nom_domaine;
if ($nom_sous_domaine != "NULL") {
    $niv_dom_sd = $niv_dom_sd . "-" . $nom_sous_domaine;
}
?>

<!-- Choix du domaine -->
<section class='saisie alert alert-warning'>
<p class='instruction'>Indiquer le domaine ou le sous domaine concerné. Un niveau est automatiquement associé à chaque domaine.</p>
<select name="num_domaine_sous_domaine" class="form-select" required>
<option value="">Choisir un domaine...</option>
<?php 
// liste des options par niveaux, domaine et sous_domaine
foreach ($DOMAINES as $niveau => $domaines) {
    foreach ($domaines as $domaine => $sous_domaines) {
        $item = $niveau."-".$domaine;
        // si pas de sous domaine, on affiche le domaine
        if (empty($sous_domaines)) {
            if ($item == $niv_dom_sd) {
                echo '<option value='.'"'.$item.'" selected>'.$niveau." - ".$domaine."</option>";
            } else {
                echo '<option value='.'"'.$item.'">'.$niveau." - ".$domaine."</option>";
            }
        } else {
            foreach ($sous_domaines as $sous_domaine) {
                $item = $item . "-" . $sous_domaine;
                if ($item == $niv_dom_sd) {
                    echo '<option value='.'"'. $item.'" selected>' . $niveau . " - " . $domaine . " - " . $sous_domaine . "</option>";
                        } else {
                            echo '<option value=' . '"' . $item . '">' . $niveau . " - " . $domaine . " - " . $sous_domaine . "</option>";
                        }
                $item = $niveau."-".$domaine;
            }
        }
        }
    }
?>
</select>
</section>

<!-- prévisualisation la question -->
<section class='saisie alert alert-warning'" >
<button class='btn btn-warning' type='button' onclick='rendu_question()' id="rendu_g">Prévisualiser la question</button>
<div id='div-rendu' class='div-rendu'>
    <div id='rendu-domaine' class='rendu-domaine'>
        <!-- emplacement pour le rendu du domaine -->
    </div>
    <div id='rendu-question'>
        <!-- emplacement pour le rendu de la question -->
    </div>
    <!-- image -->
    <img id="rendu-img" class="img-question" src="#" alt="" /> 
    <!-- Groupe de cases à cocher pour les réponses -->
    <!-- réponse A -->
    <div class="input-group my-4" id=repA>
        <div class="input-group-text">
            <input class="form-check-input mt-0" type="radio" name="radio-rep" id="radio-repA">
        </div>
        <label id="rendu-repA" class="form-check-label form-control" for="radio-repA">
            Reponse A
        </label>
    </div>

    <!-- réponse B -->
    <div class="input-group  my-4" id=repB>
        <div class="input-group-text">
            <input class="form-check-input mt-0" type="radio" name="radio-rep" id="radio-repB">
        </div>
        <label id="rendu-repB" class="form-check-label form-control" for="radio-repB">
            Reponse B
        </label>
    </div>

    <!-- réponse C -->
    <div class="input-group  my-4" id=repC>
        <div class="input-group-text">
            <input class="form-check-input mt-0" type="radio" name="radio-rep" id="radio-repC">
        </div>
        <label id="rendu-repC" class="form-check-label form-control" for="radio-repC">
            Reponse C
        </label>
    </div>

    <!-- réponse D -->
    <div class="input-group  my-4" id=repD>
        <div class="input-group-text">
            <input class="form-check-input mt-0" type="radio" name="radio-rep" id="radio-repD">
        </div>
        <label id="rendu-repD" class="form-check-label form-control" for="radio-repD">
            Reponse D
        </label>
    </div>
    <!-- réponse par défaut -->
    <div class="input-group  my-4" id=repE>
        <div class="input-group-text">
            <input class="form-check-input mt-0" type="radio" name="radio-rep" id="radio-repE" checked>
        </div>
        <label class="form-check-label form-control" for="radio-repE">
            Je ne sais pas...
        </label>
    </div>
</div>
</section>

<?php
// champ caché pour stocker le id de la question
echo '<input type="hidden" name="id_question" value="'.$id_question.'">';
?>

<!-- Bouton pour tout valider et insérer la question dans la base -->
<button class='btn btn-primary' type='submit' id="insertion_g">Enregistrer les modifications</button>
</form>

<?php
}
include("footer.php");
?>