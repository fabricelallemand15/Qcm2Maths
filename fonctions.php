
<?php
// fonction pour afficher la question  dont id_question est $id_question
function afficher_question($id_question, $mode = "sans_réponses", $ordre = 1)
{
    global $bdd;
    $req = $bdd->prepare("SELECT * FROM question WHERE id_question = ?");
    $req->execute(array($id_question));
    $question = $req->fetch();
    echo "<div class='question'>";
    echo "<p><b>Question n°".$ordre." (Réf. #".$question['id_question'].")</b></p>";
    echo "<div class='texte_question md'>";
    echo $question['texte'] ;
    echo "</div>";
    if ($question['nom_image'] != NULL) {
        echo "<img class='image_question' src='images/" . $question['nom_image'] . "' alt='image de la question'>";
    }
    // Groupe de boutons radio pour les réponses
        // réponse A
        echo '<div class="input-group my-4" id=repA>';
        echo '    <div class="input-group-text">';
        echo '        <input class="form-check-input mt-0" type="radio" name="radio-rep" id="radio-repA">';
        echo '    </div>';
        echo '    <label id="rendu-repA" class="form-check-label form-control md" for="radio-repA">';
        echo $question['reponseA'];
        echo '    </label>';
        if ($mode == "avec_reponses") {
            if ($question['bonne_reponse'] == 'A') {
                echo '<span class="input-group-text">Bonne réponse</span>';
            } else {
                echo '<span class="input-group-text">Mauvaise réponse</span>';
            }
        }
        echo ' </div>';
        // réponse B
        echo '<div class="input-group my-4" id=repB>';
        echo '    <div class="input-group-text">';
        echo '        <input class="form-check-input mt-0" type="radio" name="radio-rep" id="radio-repB">';
        echo '    </div>';
        echo '    <label id="rendu-repB" class="form-check-label form-control md" for="radio-repB">';
        echo $question['reponseB'];
        echo '    </label>';
        if ($mode == "avec_reponses") {
            if ($question['bonne_reponse'] == 'B') {
                echo '<span class="input-group-text">Bonne réponse</span>';
            } else {
                echo '<span class="input-group-text">Mauvaise réponse</span>';
            }
        }
        echo ' </div>';
        // réponse C
        echo '<div class="input-group my-4" id=repC>';
        echo '    <div class="input-group-text">';
        echo '        <input class="form-check-input mt-0" type="radio" name="radio-rep" id="radio-repC">';
        echo '    </div>';
        echo '    <label id="rendu-repC" class="form-check-label form-control md" for="radio-repC">';
        echo $question['reponseC'];
        echo '    </label>';
        if ($mode == "avec_reponses") {
            if ($question['bonne_reponse'] == 'C') {
                echo '<span class="input-group-text">Bonne réponse</span>';
            } else {
                echo '<span class="input-group-text">Mauvaise réponse</span>';
            }
        }
        echo ' </div>';
        // réponse D
        echo '<div class="input-group my-4" id=repD>';
        echo '    <div class="input-group-text">';
        echo '        <input class="form-check-input mt-0" type="radio" name="radio-rep" id="radio-repD">';
        echo '    </div>';
        echo '    <label id="rendu-repD" class="form-check-label form-control md" for="radio-repD">';
        echo $question['reponseD'];
        echo '    </label>';
        if ($mode == "avec_reponses") {
            if ($question['bonne_reponse'] == 'D') {
                echo '<span class="input-group-text">Bonne réponse</span>';
            } else {
                echo '<span class="input-group-text">Mauvaise réponse</span>';
            }
        }
        echo ' </div>';
        echo '<div class="input-group  my-4" id=repE>';
        echo '<div class="input-group-text">';
        echo '    <input class="form-check-input mt-0" type="radio" name="radio-rep" id="radio-repE" checked>';
        echo '</div>';
        echo '<label class="form-check-label form-control" for="radio-repE">
            Je ne sais pas...';
        echo '</label>';
    echo '</div>';
    echo "</div>";
    echo "</div>";
}