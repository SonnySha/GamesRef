
   <?php
    require_once('controller/elementsView.php');
    
    if($myDashboard) {
        $textSignature = "Votre signature : ";
        $textRang = "Vous êtes au rang de ";
        $textNbComments = "Vous avez posté ";
        $textNbLike = "Vous avez aimé ";
    } else {
        $textSignature = "Sa signature : ";
        $textRang = $infosAccount['pseudo'] . " est au rang de ";
        $textNbComments = "Il a posté ";
        $textNbLike = "il a aimé  ";
    }
    
    
?>
    
   <div class="col-md-9 col-sm-9">
<?php
       elementUserDetails($infosAccount['id']);
?>
   <p class="pull-right"><em>Inscrit depuis le : <?=$infosAccount['inscription_date']?></em></p>
    
    
<?php
  
    $memberGrade = "Membre.";
                 
    switch($infosAccount['authorization']) {
        case 0:
            $memberGrade = "Membre.";
            break;
            
        case 1: 
            $memberGrade = "Participant.";
            break;
        case 2:
            $memberGrade = "Admin.";
            break;
    }
    
?>
    
    
       <p class="text-success"><strong><?= $textRang ?><?= $memberGrade ?></strong></p>
    <p class="text-info"><i class="fas fa-comments"></i> <?= $textNbComments ?><?= $numberCommentsAuthor ?> commentaires.</p>
    <p class="text-info"><i class="fas fa-heartbeat"></i> <?= $textNbLike ?><?= $numberFavoritesAuthor ?> jeux.</p>
    
    

</div>
