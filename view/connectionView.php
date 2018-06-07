

<?php ob_start() ?>

<div class="jumbotron text-center header-color-custom">
    <img style="heigth:250px; width:200px;margin-bottom:25px;" src="public/picture/web/internt_web_technology-13-512.png" >
    <form action="action/connection" method="post">
        <div class="input-group col-md-12 form-connection">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input id="pseudo" type="text" class="form-control" name="pseudo-connection" placeholder="Pseudo">
        </div>
        <div class="input-group col-md-12 form-connection">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input id="password" type="password" class="form-control" name="password-connection" placeholder="Mot de passe">
        </div>
             <input style="margin-right:16%;" type="submit" class="btn btn-success col-md-5" value="Connexion">
            <a href="action/registration" style="margin-left:3px;" class="btn btn-info col-md-5 "><span class="glyphicon glyphicon-eject"></span> Inscription</a>
    </form>
    
</div>


<?php $content = ob_get_clean() ?>
<?php require('view/template.php') ?>
