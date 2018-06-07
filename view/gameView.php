<?php require_once('model/AccountManager.php')  ?>
<?php require_once('controller/elementsView.php'); ?>

<?php 
    $accountExist = false;
    
    if(isset($_SESSION['pseudo']) && isset($_SESSION['password'])) {
        $accountManager = new AccountManager;
        $accountExist  = $accountManager -> connexionAccount($_SESSION['pseudo'], $_SESSION['password']); 
    }
    
    

    //Favorite
            $pseudoFavorites = $favoriteManager->getFavoritesByGames($game['id']);
            $arrayPseudoFavorite = $pseudoFavorites->fetchAll();
            $nbLikeForGame = count($arrayPseudoFavorite);


?>



<?php ob_start() ?>

<div id="area_description" class="col-md-12 row game-color-custom">
    <h1 class="nameGame col-md-12">
        <strong><?= $game['name']; ?></strong>
    </h1>
    <img style="height:500px; width:400px;" class="col-md-6 img-thumbnail" src="public/picture/games_pictures/<?= $game['file_picture'] ?>" alt="pochette de jeux">
    <div id="list-description" class="col-md-6">
        <aside>
            <ul class="ul-description-game">
                <li>
                    <?php echo 'nom : ' . $game['name']; ?>
                </li>
                <li>
                    <?php echo 'Développeur : ' . $game['developer']; ?>
                </li>
                <li>
                    <?php echo 'date de lancement : ' . $game['launch_date']; ?>
                </li>
                <li>
                    genres :
                    <?php
                    //badge genres
                    $genres = $game['genres'];
                    $arrayGenres = explode(" ", $genres);
                    for($i = 0; $i <= (count($arrayGenres)-1); ++$i) {
?>
                        <a href="action/search/genres/<?= $arrayGenres[$i]; ?>/1"><span class="label label-success"><?= $arrayGenres[$i]; ?></span></a>
                        <?php
                    }
                    //fin badge genres
?>
                </li>
                <li>
                    themes :
                    <?php
                    //badge theme
                    $themes = $game['themes'];; 
                    $arrayThemes = explode(" ", $themes);
                    for($i = 0; $i <= (count($arrayThemes)-1); ++$i) {
?>
                        <a href="action/search/themes/<?= $arrayThemes[$i]; ?>/1"><span class="label label-success"><?= $arrayThemes[$i]; ?></span></a>
                        <?php
                    }
                    //fin badge theme
?>
                </li>
                <li>
                    Nombres de joueurs :
                    <?php 
                    for($i = 1; $i <= $game['nb_players']; $i++) {
                        echo '<span class="glyphicon glyphicon-user"></span>' . ' ';
                    }
?>

                </li>
                <li>
                    console :
                    <?php
                    //badge consoles
                    $consoles = $game['consoles'];
                    $arrayConsoles = explode(" ", $consoles);
                    for($i = 0; $i <= (count($arrayConsoles)-1); ++$i) {
?>
                        <a href="action/search/consoles/<?= $arrayConsoles[$i]; ?>/1"><span class="label label-success"><?= $arrayConsoles[$i]; ?></span></a>
                        <?php
                    }
                    //fin badge consoles
?>

                </li>
            </ul>
        </aside>


    </div>
    <div id="area-description" class="col-md-12">
        <a id="btn-nbLike-game" data-toggle="modal" href="#likeList" class="btnGameBadge pull-right btn btn-lg btn-danger">
                                    <span class="glyphicon glyphicon-heart"></span><?php echo ' ' . $nbLikeForGame; ?> personne(s) aime <?= $game['name'] ?> </a>


        <p style="font-size:1.5em;" class="resume-game  description-game col-md-12">Descritpion : <br>
            <?= $game['description']; ?>
        </p>
    </div>

    <h3 class="comment-game col-md-12"><strong class="">commentaires :</strong></h3>

    <div id="areaComments" class="col-md-12">


        <?php  
        
        //Paggin
        $nbPaggin = ceil(count($comments) / 5);
        if($nbPaggin == 0) {
            $nbPaggin = 1;
        }

?>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <?php
        for($i = 0; $i < ($nbPaggin + 2); $i++) {
 
            if($i == ($nbPaggin + 1)) {
                if(($_GET['page'] + 1) > $nbPaggin) {
?>
                    <li class="page-item disabled"><a class="page-link" href="action/game/<?= $_GET['id'] ?>/<?= $nbPaggin ?>">Suivant</a></li>
                    <?php
                } else {
?>
                        <li class="page-item"><a class="page-link" href="action/game/<?= $_GET['id'] ?>/<?= $_GET['page'] + 1 ?>">Suivant</a></li>
                        <?php
                }
                break;
            }
            
            if($i == 0) {
                if(($_GET['page'] - 1) < 1) {
                    $numPrevious = 1;
?>
                            <li class="page-item disabled"><a class="page-link" href="action/game/<?= $_GET['id'] ?>/1">Précédent</a></li>
                            <?php
                } else {
?>
                                <li class="page-item"><a class="page-link" href="action/game/<?= $_GET['id'] ?>/<?= $_GET['page'] - 1 ?>">Précédent</a></li>
                                <?php
                }
            } else {
                
                if($i == $_GET['page']) {
?>
                                    <li class="page-item active">
                                        <a class="page-link" href="action/game/<?= $_GET['id'] ?>/<?= $i ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                    <?php  
                } else {
?>
                                    <li class="page-item">
                                        <a class="page-link" href="action/game/<?= $_GET['id'] ?>/<?= $i ?>">
                                            <?= $i ?>
                                        </a>
                                    </li>
                                    <?php
                    }
            }
        }
?>
            </ul>
        </nav>
        <?php       
        
        $start = ($_GET['page'] * 5) - 5;
        $end = $start + 5;
        
        for($iRow = $start; $iRow < $end; $iRow++) {
            if($iRow >= count($comments)) {
                break;
            }
            $infoAccount = $accountManager -> getInfoById($comments[$iRow]['author_id']);
?>
        <div class="col-sm-1 col-xs-3 comment-avatarAuthor">
            <div class="thumbnail">
               <a href="action/viewdashboard/<?= $infoAccount['id'] ?>"><img class="img-responsive user-photo" src="public/picture/avatar_pictures/<?= $infoAccount['avatar'] ?>"></a>
                
            </div>
            <!-- /thumbnail -->
        </div>
        <!-- /col-sm-1 -->

        <div class="col-sm-5 col-xs-9 comment-textComment">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="action/viewdashboard/<?= $infoAccount['id'] ?>" class="a-viewDashboard"><strong><?= $infoAccount['pseudo'] ?></strong></a> <span class="text-muted"><?= $comments[$iRow]['comment_date'] ?></span>
                </div>
                <div class="panel-body">
                    <?= nl2br($comments[$iRow]['comment']) ?>
                </div>

            </div>

        </div>



        <?php
        }
  
    ?>

     <div id="formComment" class="col-md-12">
        <form action="action/addComment/<?= $game['id'] ?>" method="post">
            <?php 
            
            if($accountExist) {
                $infoAccount2 = $accountManager -> infoAccount($_SESSION['pseudo']);
?>
            <p>Que pensez vous de ce jeu ? : <img class="avatarUser" src="public/picture/avatar_pictures/<?= $infoAccount2['avatar'] ?>" alt="Avatar de <?= $infoAccount2['avatar'] ?>"> <strong><?= $infoAccount2['pseudo'] ?></strong></p>
            <div class="form-group">
                <label for="comment">Entrez votre commentaire</label>
                <textarea name="comment" type="text" class="form-control" id="comment"></textarea>
                <input type="submit" id="btn-submit-commentaire" class="btn btn-info pull-right" value="Valider mon commentaire">
            </div>
            <?php
            } else {
            ?>
                <p>Vous devez être connecté pour pouvoir laisser un commentaire.</p>
                <p>Inscrivez-vous sans plus attendre ! </p>
                <p><a href="action/registration">s'inscrire maintenant</a> / <a href="action/connection">Se connecter</a></p>
                <?php
                
            }
 
            ?>


                    

        </form>

    </div>

    </div>



</div>

<?php
    elementModalLike($game['name'], $arrayPseudoFavorite,$accountManager, "likeList");
?>


    <?php $content = ob_get_clean() ?>
    <?php require('view/template.php') ?>
