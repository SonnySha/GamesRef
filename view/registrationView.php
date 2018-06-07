<?php ob_start() ?>

<div class="jumbotron header-color-custom">

    <p class="textRegistration">L'inscription ne vous prendra que quelque instant. <br> <br>
        Merci de renseigner votre <strong>pseudo</strong> ainsi que votre <strong>mot de passe</strong>. <br><br>
        <em class="infoAccount">Vous allez pouvoir par la suite pouvoir enregistrer votre propre avatar et votre signature dans votre espace personnel.</em>
    </p>
    
    <form action="action/registration" method="post">
        <div class="form-group">
            <label for="pseudo-registration">Entrez votre <strong>Pseudo</strong></label>
            <input name="pseudo" type="text" class="form-control" id="pseudo-registration">
        </div>
        <div class="form-group">
            <label for="password1-registration">Entrez votre <strong>Mot de passe</strong></label>
            <input name="password1" type="password" class="form-control" id="password1-registration">
        </div>
        <div class="form-group">
            <label for="password2-registration">Retapez votre <strong>Mot de passe</strong></label>
            <input name="password2" type="password" class="form-control" id="password2-registration">
        </div>
        <input type="submit" class="btn btn-info" value="Valider mon inscription">

    </form>

</div>



<?php $content = ob_get_clean() ?>
<?php require('view/template.php') ?>


