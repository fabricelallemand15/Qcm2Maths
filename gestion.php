<?php session_start();
include("config.php");
include("head.php");

if (empty($_SESSION) or $_SESSION['connecte'] != true) :
    include("header.php");
    echo "Vous ne devriez pas être ici : <a href='index.php'>Retour</a>";
else :
    include("header.php");
    include("nav.php");

    // L'utilisateur actuel est-il un admin ?
    $texte_req = "";
    if ($_SESSION['qualite'] == 'prof') {
        $texte_req = 'SELECT *, DATE_FORMAT(question.date_creation, "%d-%m-%Y") AS date_aj, utilisateur.nom, utilisateur.prenom
            FROM question
            INNER JOIN domaine ON question.id_domaine = domaine.id_domaine
            INNER JOIN utilisateur ON question.id_auteur = utilisateur.id_utilisateur
            WHERE question.id_auteur = ' . $_SESSION['id_utilisateur'].'
            ORDER BY id_question';
    } else if ($_SESSION['qualite'] == 'admin') {
        $texte_req = 'SELECT *, DATE_FORMAT(question.date_creation, "%d-%m-%Y") AS date_aj, utilisateur.nom, utilisateur.prenom
        FROM question
        INNER JOIN domaine ON question.id_domaine = domaine.id_domaine
        INNER JOIN utilisateur ON question.id_auteur = utilisateur.id_utilisateur
        ORDER BY id_question';
    }

    $req_domaines = $bdd->prepare($texte_req);
    $req_domaines->execute();

    $questions = $req_domaines->fetchAll();

?>
    <h1 class='h1-qcm'>Gestion des questions</h1>

    <p>Vous pouvez ici modifier ou supprimer des questions.</p>

    <p>Seules les questions dont vous êtes l'auteur sont affichées (sauf pour les administrateurs).</p>

    <div id="table-questions-container">
        <table id="table-questions" class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Numéro</th>
                    <th scope="col">Date d'ajout</th>
                    <th scope="col">Domaine</th>
                    <th scope="col">Sous-domaine</th>
                    <th scope="col">Auteur</th>
                    <th scope="col">Texte</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($questions as $question) : ?>
                    <tr>
                        <td><?= $question['id_question'] ?></td>
                        <td><?= $question['date_aj'] ?></td>
                        <td><?= $question['id_domaine'] ?></td>
                        <td><?= $question['id_sous_domaine'] ?></td>
                        <td><?= $question['prenom'] . ' ' . $question['nom'] ?></td>
                        <td><span class="md"><?= $question['texte'] ?></span></td>
                        <td>
                            <!-- groupe de boutons : modifier et supprimer -->
                            <div class="btn-group" role="group">
                                <form action="modif-question.php" method="post">
                                    <input type="hidden" name="id_question" value="<?= $question['id_question'] ?>">
                                    <button type="submit" class="btn btn-outline-success"><i class="bi bi-pencil"></i></button>
                                </form>
                                <form action="suppr_question.php" method="post">
                                    <input type="hidden" name="id_question" value="<?= $question['id_question'] ?>">
                                    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

<?php
endif;
?>
<script type="text/javascript">
$(document).ready( function () {
    $('#table-questions').DataTable({
        language: {
        processing:     "Traitement en cours...",
        search:         "Rechercher&nbsp;:",
        lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
        info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
        infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
        infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
        infoPostFix:    "",
        loadingRecords: "Chargement en cours...",
        zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
        emptyTable:     "Aucune donnée disponible dans le tableau",
        paginate: {
            first:      "Premier",
            previous:   "Pr&eacute;c&eacute;dent",
            next:       "Suivant",
            last:       "Dernier"
        },
        aria: {
            sortAscending:  ": activer pour trier la colonne par ordre croissant",
            sortDescending: ": activer pour trier la colonne par ordre décroissant"
        }
    }
        });
    MD_to_html();
} );
</script>
<?php include("footer.php") ?>