<header class="header">
    <?php
    if (isset($bdd) and isset($_SESSION['connecte']) and $_SESSION['connecte'] == true) {
      $req = $bdd->prepare('SELECT prenom, nom, mail FROM utilisateur WHERE id_utilisateur = ?');
      $req->execute(array($_SESSION['id_utilisateur']));
      $coordonnees = $req->fetch();
    ?>

        <nav class="navbar navbar-expand-lg bg-primary bg-gradient bg-opacity-50">
  <div class="container-fluid">
  <a href='accueil.php'><img src="images/logo_QcmEval.png" alt="logo QcmEval" id='logo_header' /></a>
        <h1 id='h1-header'>QcmEval - QCM de <?php echo MATIERE ?> </h1>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavDarkDropdown" >
      <ul class="navbar-nav" id="menu_utilisateur_header">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="bi bi-person-check"></i><?= $coordonnees['nom'] ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li class="menu_item"><?= $coordonnees['prenom'] ?> <?= $coordonnees['nom'] ?></li>
            <li class="menu_item"><?= $coordonnees['mail'] ?></li>
            <li><hr class="dropdown-divider"></li>
            <li class="menu_item"><a class="dropdown-item" href="deconnexion.php">Déconnexion</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<?php } else { ?>
  <nav class="navbar navbar-expand-lg bg-primary bg-gradient bg-opacity-50">
  <div class="container-fluid">
  <a href='index.php'><img src="images/logo_QcmEval.png" alt="logo QcmEval" id='logo_header' /></a>
        <h1 id='h1-header'>QcmEval - QCM de <?php echo MATIERE ?></h1>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse d-flex justify-content-end" id="navbarNavDarkDropdown" >
      
    </div>
  </div>
</nav>
<?php } ?>
</header>