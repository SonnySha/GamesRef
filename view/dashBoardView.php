<?php ob_start() ?>

<?php
  
    
    
?>

<div id="jumbotronDashboard" class="jumbotron">
    <?php
        $btnDisconnect = "";
            if($myDashboard) {
                $btnDisconnect = '<a href="action/disconnect" class="btn btn-danger btn-lg pull-right">déconnexion</a>';
            }
?>
    <p><em><?= $titreDashboard ?><?= $btnDisconnect ?></em></p>

    

    <div id="areaOptionDashboard">
        <ul class="nav nav-pills nav-stacked pull-right">
            <li class="active"><a href="#profil" data-toggle="tab"><?=$texteOngletProfil ?></a></li>
            <li><a href="#comments" data-toggle="tab"><?=$texteOngletCommentaire ?></a></li>
            <li><a href="#favorites" data-toggle="tab"><?=$texteOngletFavoris ?></a></li>
<?php
            if($myDashboard) {
                echo '<li><a href="#parameter" data-toggle="tab">Paramètres</a></li>';
            }
?>
            
        </ul>
        <div class="tab-content">
            <div class=" tab-pane fade active in " id="profil">
               <div class="row">
                   <?php require('view/dashTabProfilView.php'); ?>
               </div>
                
            </div>
            <div class="row tab-pane fade " id="comments">
                <?php require('view/dashTabCommentsView.php'); ?>
            </div>
            <div class="row tab-pane fade " id="favorites">
                <?php require('view/dashTabFavorisView.php'); ?>
            </div>
<?php
            if($myDashboard) {
                echo '<div class="row tab-pane fade" id="parameter"><em>Fonction en cour de création</em></div>';
            }
?>
            
        </div>
    </div>



</div>


<?php $content = ob_get_clean() ?>
<?php require('view/template.php') ?>
