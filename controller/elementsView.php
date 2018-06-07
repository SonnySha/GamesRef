<?php
require_once('controller/controllerFavorite.php');
require_once('controller/controllerComment.php');
require_once('controller/controllerAccount.php');
//********************************************************* ELEMENTS

/**
 * Affiche un badge de connexion avec l'avatar et le pseudo de l'utilisateur
 *
 * @param string $imgAccount Nom de l'avatar
 * @param string $nameAccount Pseudo de l'utilisateur
 */
function elementConnexionOn($imgAccount, $nameAccount) {
    //Créer le bouton pour l'utilisateur connecté
?>
    <div id="div-btn-connection-top">
        <a href="action/dashboard" class="btn-connection-top hover-btn"><span><img id="img-btn-connection" src="public/picture/avatar_pictures/<?= $imgAccount ?>" alt="avatar de <?= $nameAccount ?>"></span> <?= $nameAccount ?></a>
    </div>

    <?php
}

/**
 * Affiche un badge de connexion basique non connecté
 */
function elementConnexionOff() {
    //Créer le bouton pour l'utilisateur non connecté
?>
        <div id="div-btn-connection-off" class="connexion-off">
            <a href="action/connection" class="btn-connection-top hover-btn"><span class="glyphicon glyphicon-user"></span> Se connecter</a>
        </div>
        <?php
}

/**
 * Fenêtre modal qui invite l'utilisateur à s'inscrire ou se connecter, le code HTML est inclu dans la fonction
 *
 * @param string $nameIdCall Nom du champ ID
 * @param string $titleModal Titre de la fenêtre modal
 * @param string $descriptionModal Description de la fenêtre modal
 *
 */
function elementInvitationToRegister($nameIdCall, $titleModal, $descriptionModal) {
?>

            <div class="modal fade" id="<?= $nameIdCall ?>" style="display: none;">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">x</button>
                            <h4 class="modal-title">
                                <?= $titleModal ?>
                            </h4>
                        </div>
                        <div class="modal-body modal-badgeLike row">
                            <p id="description-modal-nody" class="col-md-12">
                                <?= $descriptionModal ?>
                            </p>
                            <div id="area-btn-registration" class="col-md-12">
                                <a href="action/connection" class="btn btn-primary"><span class="glyphicon glyphicon-user"></span> Connection</a>
                                <a href="action/registration" class="btn btn-warning"><span class="glyphicon glyphicon-ok"></span> Inscription</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
    
}

/**
 * Charge le bon logo pour la console passé en paramètre.
 *
 * @param string $console Nom de la console
 *
 * @return string Retourne le bon logo chargé sur Font Awesome
 */
function logoConsole($console) {
    //retourne le texte à mettre dans le <i>
    $logo = "";
    switch($console) {
        case 'Pc':
            $logo = "fas fa-laptop";
            break;
        
        case 'Ps3':case 'Ps4':
            $logo = "fab fa-playstation";
            break;
        case 'Xbox':case 'One':
            $logo = "fab fa-xbox";
            break;
        case 'Switch':
            $logo = "fab fa-nintendo-switch";
            break;
        
        default:
            $logo = "fas fa-gamepad";
    }
    
    return $logo;
}

/**
 * Retourne le rang de l'utilisateur par rapport à son autorisation.
 *
 * @param int $numAuthorization Numéro de l'autorisation
 *
 * @return string rang
 */
function getTexteAuthorization($numAuthorization) {
    //retourne le rang par rapport au numero de l'autorization
    $numAuthorization = (int) $numAuthorization;
    $rang = "";
    switch($numAuthorization) {
        case 1:
            $rang = "Admin";
            break;
            
        default:
            $rang = "Membre";
    }
    
    return $rang;
}

function getTexteLike($numLike) {
    $numLike = (int) $numLike;
    $texte = "aucun";
    switch($numLike) {
        case ($numLike >= 9):
            $texte = "Grand loveur !!";
            break;
        case ($numLike > 5):
            $texte = "Likeur affranchi";
                break;
        case ($numLike > 3):
            $texte = "Jeune likeur";
            break;
        case ($numLike > 1):
            $texte = "Explorateur";
            break;
    }
    
    return $texte;
}

function getTexteComment($numbreComment) {
    $texte = "Explorateur";
    switch($numbreComment) {
        case ($numbreComment >= 9):
            $texte = "Grande pipelette";
            break;
        case ($numbreComment > 5):
            $texte = "Causeur indépendant";
                break;
        case ($numbreComment > 3):
            $texte = "Jeune bavard";
            break;
        case ($numbreComment >= 1):
            $texte = "Muet";
            break;
    }
    
    return $texte;
}



function elementOverviewGame($game, $iRow, $tabGenres, $tabConsoles, $nbLikeForGame, $arrayPseudoFavorite,$accountManager, $idUser, $heartForm, $nameIdCallModalRegistration) {
    //Apercu du jeux sur un jumbotron
    
    //Gére le bouton like
    $hrefForAddFavorite = "";
    $dataToggleForAddFavorite = "";
    if($idUser == -1) {
        $hrefForAddFavorite = "#" . $nameIdCallModalRegistration;
        $dataToggleForAddFavorite = "modal";
    } else {
        $hrefForAddFavorite = "action/addFavorite/" . $game[$iRow]['id'] . "/" . $idUser;
        $dataToggleForAddFavorite = "";
    }
    
    
?>
                <div id="jumbotron-games-list" class="jumbotron row ">
                    
                    <div id="game-presentation" class="col-md-12 col-sm-11">
                        <img src="public/picture/games_pictures/<?= $game[$iRow]['file_picture']; ?>" class="col-md-4 col-sm-5 game_picture">
                        <aside class="col-md-4 col-sm-6">
                            <h3 class="nameGame col-md-12 col-sm-12">
                                <?= $game[$iRow]['name'] ?>
                            </h3>
                            <ul id="list-genres-<?=$game[$iRow]['name']?>" class="list-genre-game col-md-12 col-sm-12">
                                <?php
                foreach($tabGenres as $genre) {
?>
                                    <li class="li-genre">
                                        <a class="label-genres" href="action/search/genres/<?= $genre ?>/1">
                                            <?= $genre ?>
                                        </a>
                                    </li>
                                    <?php
                }
?>
                            </ul>
                        </aside>
                        <div class="col-md-4 col-sm-6" id="area-btn-nav">

                            <a href="action/game/<?= $game[$iRow]['id'] ?>/1" id="btn-view-game" class="btnGameBadge btn btn-lg btn-primary col-md-12"><span class="glyphicon glyphicon-eye-open"></span> Voir le jeux</a>

                            <div class="btn-group">
                                <a class="btn btn-danger" href="<?= $hrefForAddFavorite ?>" data-toggle="<?=$dataToggleForAddFavorite?>"><span class="btn-favorite <?= $heartForm ?> fa-heart fa-2x "></span></a>
                                <a id="btn-nbLike" data-toggle="modal" href="#likeList<?= $game[$iRow]['id'] ?>" class="btnGameBadge btn btn-lg btn-danger ">
                                    <?php echo ' ' . $nbLikeForGame; ?> personne(s) ont aimé</a>
                            </div>

                        </div>

                        <!--
                        
                        <a id="btn-likex" data-toggle="modal" href="#likeList<?= $game[$iRow]['id'] ?>" class="btnGameBadge btn btn-lg btn-warning col-md-12"><span class="glyphicon glyphicon-heart"></span><?php echo ' ' . $nbLikeForGame; ?> personnes l'ont aimé</a>
                        
                        -->



                    </div>
                    <div class="game-consoles col-md-12 col-sm-1" id="game-consoles-<?=$game[$iRow]['name']?>">
                        <ul class="list-consoles-available">
                            <?php
                        foreach($tabConsoles as $console) {
                            $logo = logoConsole($console);
                            
?>


                                <li class="li-consoles">
                                    <a class="labelconsoles label-<?= $console ?>" href="action/search/consoles/<?=$console?>/1">
                                            <i class="<?= $logo ?>"></i> <?= $console ?>
                                        </a>
                                </li>
                                <?php
                        }
?>
                        </ul>
                    </div>
                    <?php
                    $nameCallModal = "likeList" . $game[$iRow]['id'];
                    elementModalLike($game[$iRow]['name'], $arrayPseudoFavorite,$accountManager, $nameCallModal);
?>



                </div>








                <?php
}

function elementUserDetails($idUser) {
    $AccountInfo = getInfoById($idUser);
    $textRang = getTexteAuthorization($AccountInfo['authorization']);
    $textRangLike = getTexteLike(countFavorites($AccountInfo['id']));
    $textRangComment = getTexteComment(numberComments($AccountInfo['id']));
?>
                    <div class="media">
                        <a class="pull-left img-avatar" href="action/viewdashboard/<?= $AccountInfo['id'] ?>">
                            <img src="public/picture/avatar_pictures/<?= $AccountInfo['avatar'] ?>" style="width: 100px;height:100px;">
                        </a>
                        <div class="media-body">
                            <a href="action/viewdashboard/<?= $AccountInfo['id'] ?>">
                                <h4 class="media-heading">
                                    <?= $AccountInfo['pseudo'] ?>
                                </h4>
                            </a>
                            <h5>
                                <?= $AccountInfo['signature'] ?>
                            </h5>
                            <hr style=" margin:8px auto ">

                            <span class="label label-<?=$textRang?>"><?= $textRang ?></span>
                            <span class="label label-rang-like label-<?=$textRangLike?>"><?= $textRangLike ?></span>
                            <span class="label label-rang-comment label-<?=$textRangLike?>"><?= $textRangComment ?></span>
                        </div>
                    </div>
                    <?php
}

function elementModalLike($gameName, $arrayPseudoFavorite,$accountManager, $nameCallModal) {
?>

                        <div class="modal fade" id="<?=$nameCallModal?>" style="display: none;">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">x</button>
                                        <h4 class="modal-title">Il(s) ont aimé
                                            <?= $gameName ?>
                                        </h4>
                                    </div>
                                    <div class="modal-bodyx modal-badgeLikex">
                                        <ul>

                                            <?php
                            for($j = 0; $j < count($arrayPseudoFavorite); $j++) {
                                $idAccount = $arrayPseudoFavorite[$j]['pseudo_id'];
                                
                                
                                elementUserDetails($idAccount);
?>



                




                                                <?php
                            }
                            
?>


                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
}
