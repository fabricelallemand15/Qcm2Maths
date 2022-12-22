-- utilisateurs:
--     - id_utilisateur: identifiant de l'utilisateur
--     - nom: nom de l'utilisateur
--     - prenom: prénom de l'utilisateur
--     - mdp: mot de passe de l'utilisateur
--     - phrase_secrete: phrase secrète de l'utilisateur (pour le mode anti-triche)
--     - mail: adresse mail
--     - avatar: nom du fichier image contenant l'avatar de l'utilisateur
--     - derniere_connexion: date de la dernière connexion
--     - verified: booléen indiquant si l'utilisateur est vérifié ou non

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_utilisateur` bigint(20) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `phrase_secrete` varchar(256) DEFAULT NULL,
  `mail` varchar(100) NOT NULL,
  `derniere_connexion` datetime NOT NULL DEFAULT current_timestamp(),
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `statut` varchar(50) NOT NULL DEFAULT 'prof'
) 

-- niveaux:
--     - id_niveau: identifiant du niveau
--     - nom: intitulé du niveau

CREATE TABLE niveau (
    id_niveau bigint(20) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL
);

-- domaines:
    -- - id_domaine: identifiant du domaine
    -- - nom: intitulé du domaine
    -- - id_niveau: identifiant du niveau


CREATE TABLE IF NOT EXISTS domaine (
    id_domaine bigint(20) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    id_niveau bigint(20) UNSIGNED NOT NULL,
    FOREIGN KEY (id_niveau) REFERENCES niveau(id_niveau)
);

-- sous_domaines:
--     - id_sous_domaine: identifiant du sous-domaine
--     - nom: intitulé du sous-domaine
--     - id_domaine: identifiant du domaine père

CREATE TABLE IF NOT EXISTS sous_domaine (
    id_sous_domaine bigint(20) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(100) NOT NULL,
    id_domaine bigint(20) UNSIGNED NOT NULL,
    FOREIGN KEY (id_domaine) REFERENCES domaine(id_domaine)
);


-- questions:
--     - id_question: identifiant de la question
--     - texte: texte de la question
--     - reponseA: texte de la réponse A
--     - reponseB: texte de la réponse B
--     - reponseC: texte de la réponse C
--     - reponseD: texte de la réponse D
--     - bonne_reponse: bonne réponse
--     - id_auteur: identifiant de l'auteur
--     - id_domaine: identifiant du domaine
--     - id_sous_domaine: identifiant du sous-domaine
--     - id_niveau: identifiant du niveau
--     - image: nom du fichier image associé à la question
--     - date_creation: date de création de la question

CREATE TABLE IF NOT EXISTS question (
    id_question bigint(20) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    texte VARCHAR(1000) NOT NULL,
    reponseA VARCHAR(1000) NOT NULL,
    reponseB VARCHAR(1000) NOT NULL,
    reponseC VARCHAR(1000) NOT NULL,
    reponseD VARCHAR(1000) NOT NULL,
    bonne_reponse VARCHAR(1) NOT NULL,
    id_auteur bigint(20) UNSIGNED NOT NULL,
    id_domaine bigint(20) UNSIGNED NOT NULL,
    id_sous_domaine bigint(20) UNSIGNED DEFAULT NULL,
    id_niveau bigint(20) UNSIGNED NOT NULL,
    image VARCHAR(100) DEFAULT NULL,
    date_creation DATE DEFAULT current_timestamp(),
    FOREIGN KEY (id_auteur) REFERENCES utilisateur(id_utilisateur),
    FOREIGN KEY (id_domaine) REFERENCES domaine(id_domaine),
    FOREIGN KEY (id_sous_domaine) REFERENCES sous_domaine(id_sous_domaine),
    FOREIGN KEY (id_niveau) REFERENCES niveau(id_niveau)
);

-- qcms:
--     - id_qcm: identifiant du qcm
--     - id_auteur: identifiant de l'auteur
--     - date_creation: date de création du qcm
--     - clef_qcm: liste des id de questions sous forme de chaîne de caractères

CREATE TABLE IF NOT EXISTS qcm (
    id_qcm bigint(20) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_auteur bigint(20) UNSIGNED NOT NULL,
    date_creation DATE DEFAULT current_timestamp(),
    clef_qcm VARCHAR(1000) NOT NULL,
    FOREIGN KEY (id_auteur) REFERENCES utilisateur(id_utilisateur)
);

-- eleves:
--     - id_eleve: identifiant de l'élève
--     - pseudo: pseudo de l'élève

CREATE TABLE IF NOT EXISTS eleve (
    id_eleve bigint(20) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    pseudo VARCHAR(100) NOT NULL
);

-- resultats:
--     - id_resultat: identifiant du résultat
--     - id_qcm: identifiant du qcm
--     - id_prof: identifiant du prof
--     - id_eleve: identifiant de l'élève
--     - reponse_eleve: réponse de l'élève sous forme de chaine de caractères avec couples id_question-réponse
--     - date_passation: date de passation du qcm
--     - note: note obtenue

CREATE TABLE IF NOT EXISTS resultat (
    id_resultat bigint(20) UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
    id_qcm bigint(20) UNSIGNED NOT NULL,
    id_prof bigint(20) UNSIGNED NOT NULL,
    id_eleve bigint(20) UNSIGNED NOT NULL,
    reponse_eleve VARCHAR(1000) NOT NULL,
    date_passation DATE DEFAULT current_timestamp(),
    note INTEGER DEFAULT 0,
    FOREIGN KEY (id_qcm) REFERENCES qcm(id_qcm),
    FOREIGN KEY (id_prof) REFERENCES utilisateur(id_utilisateur),
    FOREIGN KEY (id_eleve) REFERENCES eleve(id_eleve)
);

-- stats:
--     - nb_visites: nombre de visites

CREATE TABLE IF NOT EXISTS stats (
    nb_visites INTEGER DEFAULT 0
);

-- Liste des niveaux :
-- Seconde
-- Première
-- Terminale

INSERT INTO niveau (nom) VALUES ('Seconde');
INSERT INTO niveau (nom) VALUES ('Première');
INSERT INTO niveau (nom) VALUES ('Terminale');

-- Liste des domaines et de leur niveau :
-- Seconde
--     - Nombres et calculs
--     - Géométrie
--     - Fonctions
--     - Statistiques et probabilités
--     - Algorithmique et programmation
--     - Vocabulaire ensembliste et logique

INSERT INTO domaine (nom, id_niveau) VALUES ('Nombres et calculs', 1);
INSERT INTO domaine (nom, id_niveau) VALUES ('Géométrie', 1);
INSERT INTO domaine (nom, id_niveau) VALUES ('Fonctions', 1);
INSERT INTO domaine (nom, id_niveau) VALUES ('Statistiques et probabilités', 1);
INSERT INTO domaine (nom, id_niveau) VALUES ('Algorithmique et programmation', 1);
INSERT INTO domaine (nom, id_niveau) VALUES ('Vocabulaire ensembliste et logique', 1);

-- Première
--     - Algèbre
--     - Analyse
--     - Géométrie
--     - Probabilités et statistiques
--     - Algorithmique et programmation
--     - Vocabulaire ensembliste et logique
--     - Analyse de l'information chiffrée
--     - Phénomènes aléatoires
--     - Phénomènes d'évolution
--     - Automatismes

INSERT INTO domaine (nom, id_niveau) VALUES ('Algèbre', 2);
INSERT INTO domaine (nom, id_niveau) VALUES ('Analyse', 2);
INSERT INTO domaine (nom, id_niveau) VALUES ('Géométrie', 2);
INSERT INTO domaine (nom, id_niveau) VALUES ('Probabilités et statistiques', 2);
INSERT INTO domaine (nom, id_niveau) VALUES ('Algorithmique et programmation', 2);
INSERT INTO domaine (nom, id_niveau) VALUES ('Vocabulaire ensembliste et logique', 2);
INSERT INTO domaine (nom, id_niveau) VALUES ("Analyse de l'information chiffrée", 2);
INSERT INTO domaine (nom, id_niveau) VALUES ('Phénomènes aléatoires', 2);
INSERT INTO domaine (nom, id_niveau) VALUES ("Phénomènes d'évolution", 2);
INSERT INTO domaine (nom, id_niveau) VALUES ('Automatismes', 2);

-- Terminale
--     - Algèbre et géométrie
--     - Analyse
--     - Probabilités
--     - Algorithmique et programmation
--     - Vocable ensembliste et logique
--     - Nombres complexes
--     - Arithmétique
--     - Graphes et matrices

INSERT INTO domaine (nom, id_niveau) VALUES ('Algèbre et géométrie', 3);
INSERT INTO domaine (nom, id_niveau) VALUES ('Analyse', 3);
INSERT INTO domaine (nom, id_niveau) VALUES ('Probabilités', 3);
INSERT INTO domaine (nom, id_niveau) VALUES ('Algorithmique et programmation', 3);
INSERT INTO domaine (nom, id_niveau) VALUES ('Vocable ensembliste et logique', 3);
INSERT INTO domaine (nom, id_niveau) VALUES ('Nombres complexes', 3);
INSERT INTO domaine (nom, id_niveau) VALUES ('Arithmétique', 3);
INSERT INTO domaine (nom, id_niveau) VALUES ('Graphes et matrices', 3);

-- Liste des sous-domaines et de leur domaine :
-- Seconde : id_niveau = 1
--     - Nombres et calculs : id_domaine = 1
--         - Manipuler les nombres réels
--         - Utiliser les notions de multiple, diviseur et de nombre premier
--         - Utiliser le calcul littéral
--     - Géométrie : id_domaine = 2
--          - Manipuler les vecteurs du plan
--          - Résoudre des problèmes de géométrie
--          - Représenter et caractériser les droites du plan
--     - Fonctions : id_domaine = 3
--          - Se constituer un répertoire de fonctions de référence
--          - Représenter algébriquement et graphiquement les fonctions
--          - Etudier les variations et les extremums d'une fonction
--     - Statistiques et probabilités : id_domaine = 4
--          - Utiliser l'information chiffrée et statistique descriptive
--          - Modéliser le hasard, calculer des probabilités
--          - Echantillonnage
--     - Algorithmique et programmation : id_domaine = 5
--          - Utiliser les variables et les instructions élémentaires
--          - Notion de fonction

INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Manipuler les nombres réels', 1);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Utiliser les notions de multiple, diviseur et de nombre premier', 1);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Utiliser le calcul littéral', 1);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Manipuler les vecteurs du plan', 2);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Résoudre des problèmes de géométrie', 2);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Représenter et caractériser les droites du plan', 2);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Se constituer un répertoire de fonctions de référence', 3);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Représenter algébriquement et graphiquement les fonctions', 3);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Etudier les variations et les extremums d''une fonction', 3);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Utiliser l''information chiffrée et statistique descriptive', 4);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Modéliser le hasard, calculer des probabilités', 4);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Echantillonnage', 4);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Utiliser les variables et les instructions élémentaires', 5);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Notion de fonction', 5);

-- Liste des sous-domaines et de leur domaine :
-- Première : id_niveau = 2
--     - Algèbre : id_domaine = 7
--         - Suites numériques, modèles discrets
--         - Équations, fonctions polynômes du second degré
--     - Analyse : id_domaine = 8
--         - Dérivation
--         - Variations et courbes représentatives des fonctions
--         - Fonction exponentielle
--         - Fonctions trigonométriques
--     - Géométrie : id_domaine = 9
--         - Calcul vectoriel et produit scalaire
--         - Géométrie repérée
--     - Probabilités et statistiques : id_domaine = 10
--         - Probabilités conditionnelles et indépendance
--         - Variables aléatoires réelles
--     - Algorithmique et programmation : id_domaine = 11
--         - Notion de liste

INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Suites numériques, modèles discrets', 7);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Équations, fonctions polynômes du second degré', 7);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Dérivation', 8);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Variations et courbes représentatives des fonctions', 8);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Fonction exponentielle', 8);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Fonctions trigonométriques', 8);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Calcul vectoriel et produit scalaire', 9);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Géométrie repérée', 9);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Probabilités conditionnelles et indépendance', 10);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Variables aléatoires réelles', 10);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Notion de liste', 11);

-- Ajouts pour les séries techno de première

INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Géométrie plane', 9);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ("Géométrie dans l'espace", 9);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Proportions et pourcentages', 16);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Évolutions et variations', 16);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Calcul numérique et algébrique ', 16);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Fonctions et représentations', 16);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Représentations graphiques de données chiffrées', 16);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Fonctions de la variable réelle', 8);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Croisement de deux variables catégorielles', 10);
INSERT INTO sous_domaine (nom, id_domaine) VALUES ('Modèle associé à une expérience aléatoire à plusieurs épreuves indépendantes', 10);

-- Liste des sous-domaines et de leur domaine :
-- Terminale : id_niveau = 3
--     - Algèbre et géométrie : id_domaine = 17
--         - Combinatoire et dénombrement
--         - Manipulation des vecteurs, des droites et des plans de l’espace
--         - Orthogonalité et distances dans l’espace
--         - Représentations paramétriques et équations cartésiennes
--     - Analyse : id_domaine = 18
--         - Suites
--         - Limites de fonctions
--         - Compléments sur la dérivation
--         - Continuité des fonctions d’une variable réelle
--         - Fonction logarithme
--         - Fonctions sinus et cosinus
--         - Primitives, équations différentielles
--         - Calcul intégral
--     - Probabilités : id_domaine = 19
--         - Succession d’épreuves indépendantes, schéma de Bernoulli
--         - Sommes de variables aléatoires
--         - Concentration, loi des grands nombres
--         - Lois discrètes
--         - Lois à densité
--         - Statistique à deux variables quantitatives
--      - Nombre complexe : id_domaine = 22
--         - Nombres complexes : point de vue algébrique
--         - Nombres complexes : point de vue géométrique
--         - Nombres complexes et trigonométrie
--         - Équations polynomiales
--         - Utilisation des nombres complexes en géométrie

-- reste à voir pour les maths expertes et terminales techno