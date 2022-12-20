<?php
// informations de l'application
define('APPNAME', 'Qcm2Maths');
define('MATIERE', 'Mathématiques');
// informations d'identification de la base de données
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', '');
define('DB_PASSWORD', '');
define('DB_NAME', '');
// informations mail
define('USERNAME', '');
define('PASSWORD', '');
define('SMTP', '');
define('PORT', 465);

// tentative de connexion à la base de données MySQL
try {
    $bdd = new PDO('mysql:host=localhost:3306;dbname=Qcm2Maths;port=3306', DB_USERNAME, DB_PASSWORD);
} catch (Exception $e) {
    die('Erreur : '.$e->getMessage());
}

// echo "Connexion à la base de données réussie";
?>
