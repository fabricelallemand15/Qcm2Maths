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

    <h1 class='titre'>Ajout de question</h1>

    <p>Vous pouvez dans cette page saisir une nouvelle question. Il suffit de compléter tous les champs proposés.</p>

    <p>Pour mettre en forme votre texte, vous pouvez utiliser la syntaxe Markdown, en laissant une ligne vide entre chaque paragraphe.</p>
    <p>Les formules mathématiques seront entrées en $\LaTeX$, encadrées du symbole "\$" pour une équation en ligne et du symbole "\$\$" pour une équation hors ligne centrée.</p>

    <p>Le code Python sera délimité par "~~~~python" et "~~~~".</p>

    <p>Il est possible d'insérer une image dans la question. Celle-ci sera toujours centrée et placée entre le texte de la question et les réponses.</p>

    <p style="color:red;">Avant d'ajouter une question assurez vous que celle-ci n'est pas déjà présente dans la base.</p>

    <p>Le bouton jaune "Prévisualiser la question" permet de vérifier votre saisie avant d'insérer la question dans la base.</p>

</div>

<!-- Début du formulaire d'ajout -->
<form id='formulaire-ajout' method='post' action='verification-ajout.php' enctype="multipart/form-data">

<!-- Texte de la question -->
<section class='saisie alert alert-warning'>
<p class='instruction'>Saisir ci-dessous la question en utilisant la syntaxe Markdown</p>
<textarea rows="20" cols="50" id='inp-question' class='inp form-control' name="question" form_id='formulaire-ajout'">
</textarea>
</section>

<!-- Image associée à la question -->
<section class='saisie  alert alert-warning'>
<p class='instruction'>Charger une image (si besoin)</p>
<p class='instruction'>Seuls les formats jpg, jpeg et png sont acceptés</p>
<p class='instruction'>Le fichier doit faire moins de 500 ko</p>
<!-- input pour charger un fichier de type .jpg .jpeg ou .png de 500ko maximum -->
<div class="input-group mb-3">
<div class="custom-file">
    <input type="file" accept="image/jpeg, image/png" max="500000" class="form-control" type="file" name="file" id="file">
</div>
<!-- bouton pour remettre à vide la valeur de id=file -->
<div class="input-group-append" id="bouton_efface">
    <button class="btn btn-danger" type="button" onclick="effaceImage()">Effacer</button>
</div>
</section>

<!-- Saisie de la réponse A -->
<section class='saisie alert alert-warning'>
<p class='instruction'>Saisir ci-dessous le code html de votre réponse A</p>
<textarea rows="10" cols="50" id='inp-repA' class='inp-rep form-control' name="reponseA" form_id='formulaire-ajout'"></textarea>
</section>

<!-- Saisie de la réponse B -->
<section class='saisie  alert alert-warning'>
<p class='instruction'>Saisir ci-dessous le code html de votre réponse B</p>
<textarea rows="10" cols="50" id='inp-repB' class='inp-rep form-control' name="reponseB" form_id='formulaire-ajout'"></textarea>
</section>

<!-- Saisie de la réponse C -->
<section class='saisie  alert alert-warning'>
<p class='instruction'>Saisir ci-dessous le code html de votre réponse C</p>
<textarea rows="10" cols="50" id='inp-repC' class='inp-rep form-control' name="reponseC" form_id='formulaire-ajout'"></textarea>
</section>

<!-- Saisie de la réponse D -->
<section class='saisie  alert alert-warning'>
<p class='instruction'>Saisir ci-dessous le code html de votre réponse D</p>
<textarea rows="10" cols="50" id='inp-repD' class='inp-rep form-control' name="reponseD" form_id='formulaire-ajout' "></textarea>
</section>

<!-- Choix de la bonne réponse -->
<section class='saisie alert alert-warning'>
<p class='instruction'>Indiquer quelle est la bonne réponse</p>
<select name="bonne_reponse" class="form-select" required>
    <option value="" id="bonne_rep_g" selected>Choisir la bonne réponse...</option>
    <option value="A" id="rep_A_g">A</option>
    <option value="B" id="rep_B_g">B</option>
    <option value="C" id="rep_C_g">C</option>
    <option value="D" id="rep_D_g">D</option>
</select>
</section>

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
                    echo '<option value='.'"'.$item.'">'.$niveau." - ".$domaine."</option>";
        } else {
            foreach ($sous_domaines as $sous_domaine) {
                $item = $item . "-" . $sous_domaine;
                echo '<option value='.'"'. $item.'">' . $niveau . " - " . $domaine . " - " . $sous_domaine . "</option>";
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
    <img id="rendu-img" class='img-question' src="#" alt="Image non trouvée..." />
    
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

<!-- Bouton pour tout valider et insérer la question dans la base -->
<button class='btn btn-primary' type='submit' id="insertion_g">Insérer la question dans la base</button>
</form>
<?php
    }
include("footer.php");
?>