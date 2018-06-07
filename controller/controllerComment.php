<?php

require_once('model/CommentManager.php');
require_once('model/AccountManager.php');
require_once('controller/controllerGames.php');

/**
 * Ajoute un commentaire sur le jeu passé en paramètre.
 *
 * @param int $game_id l'identifiant du jeu qui est commenté
 * @param string $comment le commentaire de l'utilisateur
 *
 */
function addComment($game_id, $comment) {
    $accountManager = new AccountManager();
    $commentManager = new CommentManager();
    
    $accountExist = $accountManager -> connexionAccount($_SESSION['pseudo'], $_SESSION['password']);
    
    if($accountExist) {
        $infosAccount = $accountManager->infoAccount($_SESSION['pseudo']);
        $idAccount = $infosAccount['id'];
        $affectedLine = $commentManager -> addComments($game_id,  $idAccount, $comment);
        if(!$affectedLine) {
            throw new Exception('Impossible d\'ajouter le commentaire !');
        } else {
            //header('Location: http://www.sonnyweb.ovh/gamesRef/action/game/' . $game_id . '/1');
            header('Location: http://localhost/gamesRef/action/game/' . $game_id . '/1');
        }
    } else {
        throw new Exception('Impossible d\'ajouter le commentaire !');
    }
    
    
    
}

/**
 * Compte le nombre de commentaires.
 *
 * @param int $game_id l'identifiant du jeu
 *
 * @return int le nombre de commentaire
 */
function numberComments($game_id) {
    $commentManager = new CommentManager();
    $comments = $commentManager->getCommentsForAuthor($game_id)->fetchAll();
    $nbComments = count($comments);
    
    return $nbComments;
}

/**
 * Liste les 3 meilleurs commentateurs.
 *
 * @return array la liste des 3 meilleurs commentateurs
 */
function listBestCommentators() {
    //Retourn un tableau avec les 3 meilleurs commentateur
    $commentManager = new CommentManager();
    $listBestCommentator = $commentManager->getBestCommentators();
    
    return $listBestCommentator;
}
