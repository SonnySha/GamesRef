<?php

require_once('model/AccountManager.php');
require_once('model/CommentManager.php');
require_once('model/FavoriteManager.php');
require_once('model/GamesManager.php');

/**
 * Affiche le dashboard de l'utilisateur actuellement connecté
 */
function MyDashboard() {
    
    $myDashboard = true;
    
    if(isset($_SESSION['pseudo']) && isset($_SESSION['password'])) {
        $accountManager = new AccountManager;
        $accountExist = $accountManager->connexionAccount($_SESSION['pseudo'], $_SESSION['password']);
        
        if($accountExist) {
            $infosAccount = $accountManager->infoAccount($_SESSION['pseudo']);
            //Commentaire
            $commentManager = new CommentManager;
            $authorComments = $commentManager->getCommentsForAuthor($infosAccount['id']);
            $arrayAuthorComments = $authorComments->fetchAll();
            $numberCommentsAuthor = count($arrayAuthorComments);
            $distinctComments = $commentManager->getDistinctCommentsForAuthor($infosAccount['id']);
            $arrayDistinctComments = $distinctComments->fetchAll();
            $numberDistinctCommentsAuthor = count($arrayDistinctComments);

            //Favorites
            $favoriteManager = new FavoriteManager;
            $authorFavorites = $favoriteManager->getFavorites($infosAccount['id']);
            $arrayFavorites = $authorFavorites->fetchAll();
            $numberFavoritesAuthor = count($arrayFavorites);

            //Game
            $gameManager = new GamesManager;

            $titreDashboard = "Mon tableau de bord";
            $texteOngletProfil = "Votre profil";
            $texteOngletCommentaire = "Vos commentaires";
            $texteOngletFavoris = "Vos jeux favoris";

            require('view/dashBoardView.php');
        } else {
            //header('Location: http://www.sonnyweb.ovh/gamesRef/');
            header('Location: http://localhost/gamesRef/');
        }
    }
    
    
    
   
    
}

/**
 * Consulter le dashboard d'un autre utilisateur
 *
 * @param int $account_id L'identifiant du compte que l'ont veut consulter
 *
 */
function viewDashboard($account_id) {
    
    $myDashboard = false;
    
    $accountManager = new AccountManager;
    //$accountExist = $accountManager->connexionAccount($_SESSION['pseudo'], $_SESSION['password']);
    
        $infosAccount = $accountManager->getInfoById($account_id);
        
        //Commentaire
        $commentManager = new CommentManager;
        $authorComments = $commentManager->getCommentsForAuthor($account_id);
        $arrayAuthorComments = $authorComments->fetchAll();
        $numberCommentsAuthor = count($arrayAuthorComments);
        $distinctComments = $commentManager->getDistinctCommentsForAuthor($account_id);
        $arrayDistinctComments = $distinctComments->fetchAll();
        $numberDistinctCommentsAuthor = count($arrayDistinctComments);
        
        
        //Favorites
        $favoriteManager = new FavoriteManager;
        $authorFavorites = $favoriteManager->getFavorites($account_id);
        $arrayFavorites = $authorFavorites->fetchAll();
        $numberFavoritesAuthor = count($arrayFavorites);
        
        //Game
        $gameManager = new GamesManager;
        
        $titreDashboard = "Tableau de bord de " . $infosAccount['pseudo'];
        $texteOngletProfil = "Voir son profil";
        $texteOngletCommentaire = "Voir ses commentaires";
        $texteOngletFavoris = "Voir ses jeux favoris";
        
        require('view/dashBoardView.php');
    
    
}