<?php
    
    if($myDashboard){
        $textTitre = "Vos jeux favoris ";
    }else {
        $textTitre = "Les jeux que " . $infosAccount['pseudo'] . " a aimer ";
    }
    
?>


<div class="col-md-9">


    <h3><i class="fas fa-heartbeat"></i> <?= $textTitre ?>(<?= $numberFavoritesAuthor ?>)</h3>


<?php
    
    for($i = 0; $i < $numberFavoritesAuthor; $i++) {
        $gameIdActif = $arrayFavorites[$i]['game_id'];
        $gameInfo = $gameManager->getGame($gameIdActif);
?>
    
    <div class="container jumbotron heart-color-custom">
        <div class="col-md-4">
            <p class="text-center col-md-12"><img class="game-miniature" src="public/picture/games_pictures/<?= $gameInfo['file_picture'] ?>"></p>
            <p class="nameGame text-center col-md-12 gameTexte-miniature">
                <strong><?= $gameInfo['name'] ?></strong>
            </p>
        </div>
        <div class="col-md-8">
            <a href="action/game/<?= $gameInfo['id'] ?>/1" class="btn-favorite-dashboard col-md-offset-2"><span class="btn-favorite fa fa-heart fa-lg"></span></a>
        </div>

    </div>
    
    
<?php      
    }
    
?>



</div>
