// fonction ombre_reponse() qui permet de faire apparaitre une ombre verte autour de reponse sélectionnée dans la balise select dont le nom est "bonne_reponse"
function ombre_reponse() {
    var select = document.getElementsByName("bonne_reponse")[0];
    var option = select.options[select.selectedIndex];
    // si c'est "A" qui est sélectionné, on met une ombre verte autour de l'élément d'identifiant "repA"
    if (option.value == "A") {
        document.getElementById("repA").style.boxShadow = "0 0 10px 5px palegreen";
        // et une ombre rouge sur les autres réponses
        document.getElementById("repB").style.boxShadow = "0 0 10px 5px orangered";
        document.getElementById("repC").style.boxShadow = "0 0 10px 5px orangered";
        document.getElementById("repD").style.boxShadow = "0 0 10px 5px orangered";
        document.getElementById("repE").style.boxShadow = "0 0 10px 5px orangered";
    }
    // si c'est "B" qui est sélectionné, on met une ombre verte autour de l'élément d'identifiant "repB"
    if (option.value == "B") {
        document.getElementById("repB").style.boxShadow = "0 0 10px 5px palegreen";
        // et une ombre rouge sur les autres réponses
        document.getElementById("repA").style.boxShadow = "0 0 10px 5px orangered";
        document.getElementById("repC").style.boxShadow = "0 0 10px 5px orangered";
        document.getElementById("repD").style.boxShadow = "0 0 10px 5px orangered";
        document.getElementById("repE").style.boxShadow = "0 0 10px 5px orangered";
    }
    // si c'est "C" qui est sélectionné, on met une ombre verte autour de l'élément d'identifiant "repC"
    if (option.value == "C") {
        document.getElementById("repC").style.boxShadow = "0 0 10px 5px palegreen";
        // et une ombre rouge sur les autres réponses
        document.getElementById("repA").style.boxShadow = "0 0 10px 5px orangered";
        document.getElementById("repB").style.boxShadow = "0 0 10px 5px orangered";
        document.getElementById("repD").style.boxShadow = "0 0 10px 5px orangered";
        document.getElementById("repE").style.boxShadow = "0 0 10px 5px orangered";
    }
    // si c'est "D" qui est sélectionné, on met une ombre verte autour de l'élément d'identifiant "repD"
    if (option.value == "D") {
        document.getElementById("repD").style.boxShadow = "0 0 10px 5px palegreen";
        // et une ombre rouge sur les autres réponses
        document.getElementById("repA").style.boxShadow = "0 0 10px 5px orangered";
        document.getElementById("repB").style.boxShadow = "0 0 10px 5px orangered";
        document.getElementById("repC").style.boxShadow = "0 0 10px 5px orangered";
        document.getElementById("repE").style.boxShadow = "0 0 10px 5px orangered";
    }
}

// fonction qui vérifie que les champs d'identifiant "inp-question", "inp-repA", "inp-repB", "inp-repC" et "inp-repD" ne sont pas vides
function verif_champs() {
    var question = document.getElementById("inp-question").value;
    var repA = document.getElementById("inp-repA").value;
    var repB = document.getElementById("inp-repB").value;
    var repC = document.getElementById("inp-repC").value;
    var repD = document.getElementById("inp-repD").value;
    if (question == "" || repA == "" || repB == "" || repC == "" || repD == "") {
        alert("Veuillez remplir tous les champs");
        return false;
    }
    return true;
}

// fonction rendu_question() qui récupère le contenu d'id="inp_question" et l'affiche dans id="rendu-question"
function rendu_question() {
    if (verif_champs()) {
    console.log("début");
    // on colorie les réponses
    ombre_reponse();
    // on récupère le domaine sélectionné
    // var select = document.getElementsByName("num_domaine_sous_domaine")[0];
    // document.getElementById("rendu-domaine").innerHTML = select.options[select.selectedIndex].text;
    // on récupère le code Markdown de la question
    var questionMD = document.getElementById("inp-question").value;
    console.log(questionMD);
    // on le convertit en HTML
    var questionHTML = DOMPurify.sanitize(marked.parse(questionMD));
    console.log(questionHTML);
    // on l'affiche dans id="rendu-question"
    document.getElementById("rendu-question").innerHTML = questionHTML;
    // on récupère le nom du fichier image d'id="file" et on l'affiche dans id="rendu-img"
    let input = document.getElementById('file');
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var img = document.getElementById('rendu-img');
            img.src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
    // on récupère le code Markdown de la réponse A
    var reponseAMD = document.getElementById("inp-repA").value;
    // on le convertit en HTML
    var reponseAHTML = DOMPurify.sanitize(marked.parse(reponseAMD));
    // on l'affiche dans id="rendu-repA"
    document.getElementById("rendu-repA").innerHTML = reponseAHTML;
    // on récupère le code Markdown de la réponse B
    var reponseBMD = document.getElementById("inp-repB").value;
    // on le convertit en HTML
    var reponseBHTML = DOMPurify.sanitize(marked.parse(reponseBMD));
    // on l'affiche dans id="rendu-repB"
    document.getElementById("rendu-repB").innerHTML = reponseBHTML;
    // on récupère le code Markdown de la réponse C
    var reponseCMD = document.getElementById("inp-repC").value;
    // on le convertit en HTML
    var reponseCHTML = DOMPurify.sanitize(marked.parse(reponseCMD));
    // on l'affiche dans id="rendu-repC"
    document.getElementById("rendu-repC").innerHTML = reponseCHTML;
    // on récupère le code Markdown de la réponse D
    var reponseDMD = document.getElementById("inp-repD").value;
    // on le convertit en HTML
    var reponseDHTML = DOMPurify.sanitize(marked.parse(reponseDMD));
    // on l'affiche dans id="rendu-repD"
    document.getElementById("rendu-repD").innerHTML = reponseDHTML;
        
    // on force le rendu Mathjax
    MathJax.typeset();

    // on force le rendu Prism
    call_prism();
    console.log("fin");
}}

// fonction qui appelle Prism
function call_prism() {
    Prism.highlightAll(true);
}

// fonction effaceImage() qui permet de retirer l'image d'id="rendu-img" et de réinitialiser l'input d'id="file"
function effaceImage() {
    document.getElementById("rendu-img").src = "";
    document.getElementById("file").value = "";
}

// fonction pour convertir le Markdown en HTML
function MD_to_html(){
    // boucle sur tous les éléments de classe md
    console.log("Début MD_to_html");
    var elements = document.getElementsByClassName("md");
    for (var i = 0; i < elements.length; i++) {
        // on récupère le contenu Markdown
        var md = elements[i].innerHTML;
        // on le convertit en HTML
        var html = DOMPurify.sanitize(marked.parse(md));
        // on l'affiche
        elements[i].innerHTML = html;
    }
}

// code pour les zones d'alertes 
function BSalert(message, type) {
    var alertPlaceholder = document.getElementById('liveAlertPlaceholder');
    var wrapper = document.createElement('div');
    wrapper.innerHTML = [
        `<div class="alert alert-${type} alert-dismissible" role="alert">`,
        `<div>${message}</div>`,
        `<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>`,
        `</div>`
    ].join('');
    alertPlaceholder.append(wrapper);
}