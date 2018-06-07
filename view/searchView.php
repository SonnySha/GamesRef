<?php ob_start() ?>

<?php require_once('controller/elementsView.php'); ?>

<?php
    $accountExist = false;
    $idUser = -1;
    if(isset($_SESSION['pseudo']) && isset($_SESSION['password'])) {

        $accountManager = new AccountManager;
        $accountExist  = $accountManager -> connexionAccount($_SESSION['pseudo'], $_SESSION['password']);


        if($accountExist) {
            $infoAccount = $accountManager -> infoAccount($_SESSION['pseudo']);
            $idUser = $infoAccount['id'];
            $arrayFavorites = getFavorites($idUser);
            $favorites = $arrayFavorites->fetchAll(PDO::FETCH_COLUMN, 0);
        } else {
            $idUser = -1;
        }

    }
    

    
    $searchLinkPadding = 'action/s';
    if(isset($_GET['standard'])) {
        $searchLinkPadding = 'action/search/' . $_GET['standard'] . '/' . $_GET['value'];
    }
    
    //PADDING
    $game = $games->fetchAll();
    
    $nbViewPage = 5;
    $start = 0;
    $end = $nbViewPage;
    
    
    $boolIndex = false;
    
    if(isset($_GET['page'])) {
        $start = ($_GET['page'] * $nbViewPage) - $nbViewPage;
        $end = $start + $nbViewPage;
    }
    
    if(!isset($game[$start][ 'file_picture'])) { 
            if($boolIndex == false) { 
                throw new Exception( 'Aucun jeux ne correspond à votre recherche ');
            }
           
        } else {
            //Paggin
        $nbPaggin = ceil(count($game) / $nbViewPage);

?>
    <h3>Resultat pour <?= $categorySearch ?> <span class="label label-default"><?= $searchValue ?></span></h3>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
<?php
            $numPage = 1;
            if(isset($_GET['page'])) {
                $numPage = $_GET['page'];
            }
        for($i = 0; $i < ($nbPaggin + 2); $i++) {
 
            if($i == ($nbPaggin + 1)) {
                if(($numPage + 1) > $nbPaggin) {
?>
                <li class="page-item disabled"><a class="page-link" href="<?= $searchLinkPadding ?>/<?= $nbPaggin ?>">Next</a></li>
<?php
                } else {
?>
                    <li class="page-item"><a class="page-link" href="<?= $searchLinkPadding ?>/<?= $numPage + 1 ?>">Next</a></li>
<?php
                }
                break;
            }
            
            if($i == 0) {
                if(($numPage - 1) < 1) {
                    $numPrevious = 1;
?>
                        <li class="page-item disabled"><a class="page-link" href="<?= $searchLinkPadding ?>/1">Previous</a></li>
<?php
                } else {
?>
                            <li class="page-item"><a class="page-link" href="<?= $searchLinkPadding ?>/<?= $numPage - 1 ?>">Previous</a></li>
<?php
                }
            } else {
                
                if($i == $numPage) {
?>
                                <li class="page-item active">
                                    <a class="page-link" href="<?= $searchLinkPadding ?>/<?= $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
<?php  
                } else {
?>
                                <li class="page-item">
                                    <a class="page-link" href="<?= $searchLinkPadding ?>/<?= $i ?>">
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
        }
    
    //FIN PADDING
    
    //Affichage jeux
    for($iRow = $start; $iRow < $end; $iRow++) { 
        if(!isset($game[$iRow][ 'file_picture'])) { 
            if($boolIndex == false) { 
                throw new Exception( 'Erreur dans l\'index de la page ! ');
            }
            break;
        }
                    $heartForm = 'far';
            $value = (string)$game[$iRow]['id'];
            if($accountExist) {
                if(in_array($value, $favorites)) {

                $heartForm = 'fa';
            } else {
                $heartForm = 'far';

            }
            }
        
        //Favorite
            $pseudoFavorites = $favoriteManager->getFavoritesByGames($game[$iRow]['id']);
            $arrayPseudoFavorite = $pseudoFavorites->fetchAll();
            $nbLikeForGame = count($arrayPseudoFavorite);
            
            
        //Genres
        //Récupére la valeur contenue dans la bdd pour les genres et les coupes puis les mets en tableau
            $tabGenres = explode(" ", $game[$iRow]['genres']);
            $tabConsoles = explode(" ", $game[$iRow]['consoles']);
            

        elementOverviewGame($game, $iRow, $tabGenres,$tabConsoles, $nbLikeForGame, $arrayPseudoFavorite,$accountManager, $idUser, $heartForm, "registrationForAddLike");
        
        elementInvitationToRegister("registrationForAddLike", "Connexion nécessaire", "Connecte-toi ou inscris-toi dès à présent pour pouvoir ajouter tes jeux favoris et accéder à ton dashboard ! C'est ultra simple et rapide :)");
?>


<?php  
       $boolIndex = true; 
    }
    
    
    
?>









<?php $content = ob_get_clean() ?>
<?php require('view/template.php') ?>