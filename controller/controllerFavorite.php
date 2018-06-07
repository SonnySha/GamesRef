<?php

require_once('model/FavoriteManager.php');

/**
 * Ajouter/Supprimer un jeu en favoris pour l'utilisateur connecté
 *
 * @param int $pseudoId L'identifiant de l'utilisateur connecté
 * @param int $gameId L'identifiant du jeu
 */
function addFavorite($pseudoId, $gameId) {
    $favoriteManager = new FavoriteManager;
    
    $affectedLine = $favoriteManager -> InsertFavorite($pseudoId, $gameId);
    
    if(!$affectedLine) {
        throw new Exception('Impossible d\'ajouter votre favoris');
    }else {
        //header('Location: http://www.sonnyweb.ovh/gamesRef/action/listGames/1');
        header('Location: http://localhost/gamesRef/action/listGames/1');
    }
}

/**
 * Récupérer la liste des jeux favoris de l'utilisateur passé en paramètre
 *
 * @param int $pseudoId L'identifiant du compte
 *
 * @return PDO la liste des jeux que l'utilisateur à "liker"
 */
function getFavorites($pseudoId) {
    $favoriteManager = new FavoriteManager;
    $favorites = $favoriteManager -> getFavorites($pseudoId);
    
    return $favorites;
}

/**
 * Compte combien de jeux l'utilisateur passé en paramètre à aimé
 *
 * @param int $pseudoId L'identifiant du compte
 *
 * @return int Nombre de jeux aimé par l'utilisateur passé en paramètre
 */
function countFavorites($pseudoId) {
    $tabFavo = getFavorites($pseudoId)->fetchAll();
    $countFavo = count($tabFavo);
    return $countFavo;
}

/**
 * Récupère les identifiants et le nombre de "like" des 3 meilleurs "likeur" du site
 *
 * @return array Liste des 3 meilleurs "likeurs" du site
 */
function getBestLikeurs() {
    //Retourne les 3meilleurs Likeurs du site
    $favoriteManager = new FavoriteManager;
    $listBestLikeur = $favoriteManager -> getBestLikeurs();
    
    return $listBestLikeur;
}