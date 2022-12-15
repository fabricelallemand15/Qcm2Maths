<?php
// informations d'identification de la base de données
define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'fabrice');
define('DB_PASSWORD', 'root');
define('DB_NAME', 'MathsQcmApp');

// tentative de connexion à la base de données MySQL
try {
    $bdd = new PDO('mysql:host=localhost:3306;dbname=MathsQcmApp;port=3306', DB_USERNAME, DB_PASSWORD);
} catch (Exception $e) {
    die('Erreur : '.$e->getMessage());
}

echo "Connexion à la base de données réussie";

// Vérifiez la connexion
// if($conn === false){
//     die("ERREUR : Impossible de se connecter. " . mysqli_connect_error());
// }
?>