

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
    
?>


<?php
    
    $nbViewPage = 5;
    $game = $games->fetchAll();
    $start = 0;
    $end = $nbViewPage;

    $boolIndex = false;

    if(isset($_GET['page'])) {
        $start = ($_GET['page'] * $nbViewPage) - $nbViewPage;
        $end = $start + $nbViewPage;
    }
    
        if(!isset($game[$start][ 'file_picture'])) { 
            if($boolIndex == false) { 
                throw new Exception( 'Erreur dans l\'index de la page ! ');
            }
            
        } else {

    
     //Paggin
        $nbPaggin = ceil(count($game) / 5);

?>
    <h2 id="titlePageListGames">Tous les jeux</h2>
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
                <li class="page-item disabled"><a class="page-link" href="action/listGames/<?= $nbPaggin ?>">Next</a></li>
<?php
                } else {
?>
                    <li class="page-item"><a class="page-link" href="action/listGames/<?= $numPage + 1 ?>">Next</a></li>
<?php
                }
                break;
            }
            
            if($i == 0) {
                if(($numPage - 1) < 1) {
                    $numPrevious = 1;
?>
                        <li class="page-item disabled"><a class="page-link" href="action/listGames/1">Previous</a></li>
<?php
                } else {
?>
                            <li class="page-item"><a class="page-link" href="action/listGames/<?= $numPage - 1 ?>">Previous</a></li>
<?php
                }
            } else {
                
                if($i == $numPage) {
?>
                                <li class="page-item active">
                                    <a class="page-link" href="action/listGames/<?= $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
<?php  
                } else {
?>
                                <li class="page-item">
                                    <a class="page-link" href="action/listGames/<?= $i ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
<?php
                    }
            }
        }
            
            //END PADDING
?>
        </ul>
    </nav>
<?php
        }
        
        
        
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
?>
<?php  
        elementInvitationToRegister("registrationForAddLike", "Connexion nécessaire", "Connecte-toi ou inscris-toi dès à présent pour pouvoir ajouter tes jeux favoris et accéder à ton dashboard ! C'est ultra simple et rapide :)");
        $boolIndex = true; 
        
    }
    
    
    
?>




    <?php $content = ob_get_clean(); ?>
    <?php $games->closeCursor(); ?>
    <?php require('view/template.php'); ?>
