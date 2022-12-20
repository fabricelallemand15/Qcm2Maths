<?php
//Step1
try {
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=MathsQcmApp;port=3306', 'fabrice', 'root');
} catch (Exception $e) {
    die('Erreur : '.$e->getMessage());
}
?>

<html>
 <head>
 </head>
 <body>
 <h1>PHP connect to MySQL</h1>
 <?php
 echo hash('sha256', 'root');
    ?>
</body>
</html>