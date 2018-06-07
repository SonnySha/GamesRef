<?php ob_start() ?>


<div class="jumbotron">
    <h1 style="color:indianred;"><i class="fas fa-exclamation-triangle"></i> Une erreur est survenu :</h1>

    <p class="text-info" style="font-size:2.5em;">
        <?= $descriptioneError ?>
    </p>
</div>


<?php $content = ob_get_clean() ?>
<?php require('view/template.php') ?>
