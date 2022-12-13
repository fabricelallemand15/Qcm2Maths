<?php include("head.php");?>

<body id="login">
<h2>Bienvenue sur MathsQcmApp</h2>
<div>
    <form id="form_login" action="" method="post">
            <img class="mb-4" src="images/logo_qcm2maths.png" alt="logo" width="72">
            <h1 class="h3 mb-3 fw-normal">Authentification</h1>
            <div class="d-grid gap-2">
                <input type="email" name="email" id="email" placeholder="Email" required/>
                <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required/>
                <button class="w-100 btn btn-lg btn-success" type="submit">Valider</button>
                <button class='w-100 btn btn-lg btn-primary' type="button" onclick="">Nouvel utilisateur ?</button>
                <button class='w-100 btn btn-lg btn-warning' type="button" onclick="">Mot de passe oublié ?</button>
            </div>
    </form>
</div>



<script>
    function post_datas() {

        let datas = {
            login: $('[name=login]').val(),
            mdp: $('[name=mdp]').val()
        };

        $.post('auth-check.php',
            datas,
            function(data) {
                if (data == "success") {
                    window.location.href = 'accueil.php'
                } else {
                    $('#id-reponse').html(data);
                }
            },
            'text'
        )
    }

    $('document').ready(function() {

        $("[name=mdp], [name=login]").on('keypress', function(e) {
            if (e.keyCode === 13) {
                post_datas();
            }
        });


        $('#bouton-envoi').on("click", post_datas);

    })
</script>

<?php include("footer.php") ?>