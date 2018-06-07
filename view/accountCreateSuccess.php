<?php ob_start() ?>


<div class="jumbotron">
   
    <h1>Bienvenue, <?= $pseudoAccount ?></h1>
    <h3 class="text-success">Félicitations, votre compte a été créé avec succès !</h3>
    
    <div class="row jumbotron jumbotronCreateAccount-color-custom">
        <div class="col-md-4">
            <img id="avatarAccountCreate" src="public/picture/avatar_pictures/<?= $avatarAccount ?>" alt="Avatar de <?= $pseudoAccount ?>">
        </div>
        <div class="col-md-8">
            <h2 id="pseudoAccount" class="text-center col-md-12"><?= $pseudoAccount ?></h2>
            <p class="col-md-12" id="pSignature">Votre signature : <br>
                <em class="text-info">Vous n'avez pas de signature pour l'instant, veuillez consulter les paramètres de votre tableau de bord pour modifier vos informations.</em>
            </p>
            
        </div>
    </div>
    
    <div class="row jumbotron">
        <a href="#" class="btn btn-primary col-md-5"><span class="glyphicon glyphicon-home"></span> Retour à l'accueil</a>
        <a href="#" class="btn btn-success col-md-offset-2 col-md-5"><span class="glyphicon glyphicon-eye-open"></span> Aller à mon tableau de bord</a>
    </div>
    
    <div class="row">
        <p>je suis heureux de vous compter parmi nos membres :)<br>
        pensez à faire un tour dans votre <strong>Tableau de bord</strong>, afin de changer d'avatar et de signature, ou de modifier votre mot de passe ou changer de pseudo.</p>
    </div>
    
</div>


<?php $content = ob_get_clean() ?>
<?php require('view/template.php') ?>
