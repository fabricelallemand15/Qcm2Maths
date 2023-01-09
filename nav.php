<?php
    if (isset($_SESSION)) {
?>
<nav class="navbar navbar-expand-lg bg-primary bg-gradient bg-opacity-50">
  <div class="container-fluid">
    <a class="navbar-brand" href="accueil.php">Accueil</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

      <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Créer un QCM
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="selection-manuelle.php">Par sélection manuelle</a></li>
          </ul>
        </li>
    
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="qcm-utilisateurs.php">Vos QCM</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Opérations sur les questions</a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="ajout.php">Ajout</a></li>
                <li><a class="dropdown-item" href="gestion.php">Gestion</a></li>
                <li><a class="dropdown-item" href="export.php">Export</a></li>
            </ul>
        </li>

        

        <li class="nav-item">
          <a class="nav-link active aria-current="page" href="aide.php">Aide</a>
        </li>

        <?php // L'utilisateur actuel est-il un admin ?
            if ($_SESSION['qualite'] == 'admin') { ?>
                 <li class="nav-item dropdown">
                     <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                         Administrateurs
                     </a>
                     <ul class="dropdown-menu">
                         <li><a class="dropdown-item" href="gest-domaines.php">Gestion domaines</a></li>
                         <li><a class="dropdown-item" href="info-util.php">Utilisateurs</a></li>
                         <li><a class="dropdown-item" href="nouvel-utilisateur-by-admin.php">Création compte sans mail académique</a></li>                         
            </ul>
                 </li>
             <?php } ?>

      </ul>
    </div>
  </div>
</nav>
 
<?php
    }