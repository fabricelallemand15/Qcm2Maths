# Projet QcmApp

Utilisation de Django. 

## Combien d'app nécessaires ?

* une page d'accueil avec authentification (prof)
* une page de création d'administration générale du site : création d'utilisateurs, de domaines, sous_domaines, niveaux, vérification des nouveaux utilisateurs, etc.
* une page de récupération de mot de passe oublié (prof)
* une page d'accueil après connexion (prof) avec menu vers les différentes actions et affichages de statistiques
* une page créer/modifier un qcm par sélection manuelle
* une page pour définir/modifier de nouvelles questions
* une page prof pour visualiser le qcm avant de le valider et éventuellement pouvoir revenir à l'édition
* une page vos qcm pour voir la liste des qcm du pros et éventuellement les éditer
* une page partager le qcm qui permet de générer un code pour la passation des élèves
* une page pour l'identification des élèves
* une page pour la passation du qcm
* une page pour le corrigé avec affichage de la note et en option le corrigé complet.

## Tables de la base de données

Chaque table correspond à un objet "Modèle" en django.

domaines:
    - id_domaine: identifiant du domaine
    - nom: intitulé du domaine
    - id_niveau: identifiant du niveau

sous_domaines:
    - id_sous_domaine: identifiant du sous-domaine
    - nom: intitulé du sous-domaine
    - id_domaine: identifiant du domaine père

niveaux:
    - id_niveau: identifiant du niveau
    - nom: intitulé du niveau

utilisateurs:
    - id_utilisateur: identifiant de l'utilisateur
    - nom: nom de l'utilisateur
    - prenom: prénom de l'utilisateur
    - mdp: mot de passe de l'utilisateur
    - phrase_secrete: phrase secrète de l'utilisateur (pour le mode anti-triche)
    - mail: adresse mail
    - avatar: nom du fichier image contenant l'avatar de l'utilisateur
    - derniere_connexion: date de la dernière connexion
    - verified: booléen indiquant si l'utilisateur est vérifié ou non

questions:
    - id_question: identifiant de la question
    - texte: texte de la question
    - reponseA: texte de la réponse A
    - reponseB: texte de la réponse B
    - reponseC: texte de la réponse C
    - reponseD: texte de la réponse D
    - bonne_reponse: bonne réponse
    - id_auteur: identifiant de l'auteur
    - id_domaine: identifiant du domaine
    - id_sous_domaine: identifiant du sous-domaine
    - id_niveau: identifiant du niveau
    - image: nom du fichier image associé à la question
    - date_creation: date de création de la question

qcms:
    - id_qcm: identifiant du qcm
    - id_auteur: identifiant de l'auteur
    - date_creation: date de création du qcm
    - clef_qcm: liste des id de questions sous forme de chaîne de caractères

eleves:
    - id_eleve: identifiant de l'élève
    - pseudo: pseudo de l'élève

resultats:
    - id_resultat: identifiant du résultat
    - id_qcm: identifiant du qcm
    - id_prof: identifiant du prof
    - id_eleve: identifiant de l'élève
    - reponse_eleve: réponse de l'élève sous forme de chaine de caractères avec couples id_question-réponse
    - date_passation: date de passation du qcm
    - note: note obtenue


Idées :

* une application administration pour la gestion des utilisateurs, des domaines, sous-domaines, niveaux, etc.
* une application profs pour la gestion des qcm, des questions, des résultats, etc.
* une application élèves pour la passation des qcm et l'affichage des résultats