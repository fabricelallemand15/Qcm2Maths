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

CREATE TABLE utilisateurs (
    id_utilisateur SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    mdp VARCHAR(256) NOT NULL,
    phrase_secrete VARCHAR(256) NOT NULL,
    mail VARCHAR(100) NOT NULL,
    avatar VARCHAR(100),
    derniere_connexion DATE NOT NULL,
    verified BOOLEAN NOT NULL
);

