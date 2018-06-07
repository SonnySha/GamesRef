<?php
    
    if($myDashboard){
        $textTitre = "Vos commentaires ";
    }else {
        $textTitre = "Les commentaires de " . $infosAccount['pseudo'];
    }
    
?>
  
   <div class="col-md-9">
    <h3><i class="fas fa-comments"></i> <?= $textTitre ?> (<?= $numberCommentsAuthor ?>)</h3>
    
    
<?php
   

    for($i = 0; $i < $numberDistinctCommentsAuthor; $i++) {

        $gameIdActif = $arrayDistinctComments[$i]['game_id'];
        $gameInfo = $gameManager->getGame($gameIdActif);
        
        
 ?>
   <div class="container jumbotron jumbotronAuthorComments-color-custom">
       <div class="col-md-4">
           <p class="text-center col-md-12"><img class="game-miniature" src="public/picture/games_pictures/<?= $gameInfo['file_picture'] ?>"></p>
           <p class="nameGame text-center col-md-12 gameTexte-miniature"><?= $gameInfo['name'] ?></p>
       </div>
       <div class="col-md-8">
<?php
        
        for($j = 0; $j < $numberCommentsAuthor; $j++) {
            if($arrayAuthorComments[$j]['game_id'] == $gameIdActif) {
?>
               <p class="font-pt"><em><?= $arrayAuthorComments[$j]['comment_date'] ?></em> <br> <?= $arrayAuthorComments[$j]['comment'] ?></p>
<?php
               
            }
        }
     
?>
           
           
       </div>
       <a class="lienPostAuthorComment pull-right" href="action/game/<?= $gameIdActif ?>/1"><strong><i class="fas fa-location-arrow"></i> Voir le post</strong></a>
        
    </div>
   
   
<?php       
    }
?>
   
  
    
    
    
   
    
    
    
    

</div>