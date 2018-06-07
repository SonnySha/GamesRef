<?php
require_once('controller/elementsView.php');

    $listNewGames = listNewRealease();
    $listBestLikeurs = getBestLikeurs();
    $listBestCommentators = listBestCommentators();
    $indexGameItem = 0;

?>

    <?php ob_start() ?>

    <section class="jumbotron">
        <section id="newRealease" class="container">
            <h1 id="titleRealease" class="col-md-12">Les nouvelles sorties</h1>


            <div class="row">
                <div class="col-md-12">
                    <div id="Carousel" class="carousel slide">

                        <ol class="carousel-indicators">
                            <li data-target="#Carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#Carousel" data-slide-to="1"></li>
                            <li data-target="#Carousel" data-slide-to="2"></li>
                        </ol>

                        <!-- Carousel items -->
                        <div class="carousel-inner">
                            <?php
                for($i=0; $i < 3; $i++) {
                    $textActive = "";
                    if($i==0) {
                        $textActive = "active";
                    }else {
                        $textActive = "";
                    }
?>
                                <div class="item <?=$textActive?>">
                                    <div class="row">
                                        <?php
                        for($i2=0; $i2<4;$i2++) {
?>
                                            <div class="col-md-3"><a href="action/game/<?=$listNewGames[$indexGameItem]['id']?>/1" class="thumbnail"><img src="public/picture/games_pictures/<?= $listNewGames[$indexGameItem]['file_picture'] ?>" alt="Image" style="max-width:100%;"></a></div>

                                            <?php  
                            $indexGameItem++;
                        }
?>




                                    </div>
                                    <!--.row-->
                                </div>
                                <!--.item-->
                                <?php  
                }
?>



                        </div>
                        <!--.carousel-inner-->
                        <a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>
                        <a data-slide="next" href="#Carousel" class="right carousel-control">›</a>
                    </div>
                    <!--.Carousel-->

                </div>
            </div>


        </section>

        <section id="ourBestUser" class="row">
            <ul id="listBestUser">
                <ul id="listBestLikeur" class="col-md-6">
                    <h2><i class="fas fa-heartbeat"></i> Les meilleurs Likeur</h2>
                    <?php
            foreach($listBestLikeurs as $likeur) {
?>
                        <li>
                            <p class="col-md-2 numb-like">
                                <?= $likeur['numb_like'] ?> <i class="fab fa-gratipay"></i> </p><span class="col-md-10"><?= elementUserDetails($likeur['pseudo_id']) ?></span></li>
                        <?php
            }
?>
                </ul>
                <ul id="listBestCommentator" class="col-md-6">
                    <h2><i class="fas fa-comments"></i> Les meilleurs commentateurs</h2>
                    <?php
            foreach($listBestCommentators as $commentator) {
?>
                        <li>
                            <p class="col-md-2 numb-comments">
                                <?= $commentator['numb_comments'] ?> <i class="far fa-comment-alt"></i> </p><span class="col-md-10"><?= elementUserDetails($commentator['author_id']) ?></span></li>
                        <?php
            }
?>
                </ul>
                <li id="bestCommentator"></li>
            </ul>
        </section>
    </section>





        <?php $content = ob_get_clean() ?>
        <?php require('view/template.php') ?>
