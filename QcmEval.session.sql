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
-- Terminale
--     - Algèbre et géométrie
--     - Analyse
--     - Probabilités
--     - Algorithmique et programmation
--     - Vocable ensembliste et logique
--     - Nombres complexes
--     - Arithmétique
--     - Graphes et matrices

INSERT INTO question (texte, reponseA, reponseB, reponseC, reponseD, bonne_reponse, id_auteur, id_domaine, id_sous_domaine, id_niveau, image) VALUES ("texte", "reponseA", "reponseB", "reponseC", "reponseD", "A", 1, 1, 1, 1, "image");