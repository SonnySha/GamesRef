<?php

require_once('model/GamesManager.php');
require_once('model/CommentManager.php');
require_once('model/FavoriteManager.php');
require_once('model/AccountManager.php');

/**
 * Récupère les informations du jeu sélectionné.
 *
 * @param int $gameId Identifiant du jeu
 * @param int $numPage Numéro de la page commence à 1
 */
function viewGame($gameId, $numPage) {
    $gameManager = new GamesManager;
    $game = $gameManager -> getGame($gameId);
    
    $commentManager = new CommentManager;
    $comments = $commentManager -> getCommments($gameId);
    
    //favorite
    $favoriteManager = new FavoriteManager();
    
    //Account info
    $accountManager = new AccountManager();
    
    require('view/gameView.php');
}

/**
 * Liste les jeux disponibles et les places dans une nouvelle variable nommée $games, pour pouvoir exploiter la liste dans view/listGamesView.php .
 */
function listGames() {
    $gamesManager = new GamesManager();
    $games = $gamesManager->getGames();
    
    //favorite
    $favoriteManager = new FavoriteManager();
    
    //Account info
    $accountManager = new AccountManager();
    
    require('view/listGamesView.php');
}

/**
 * Affiche la liste des jeux pour la console passée en paramètre et les affiches view/searchView.php.
 *
 * @param string $name_console Le nom de la console
 */
function searchGamesConsoles($name_console) {
    $gamesManager = new GamesManager();
    $games = $gamesManager->searchGamesConsoles($name_console);
    
    $categorySearch = "les jeux sur ";
    $searchValue = $name_console;
    
    $favoriteManager = new FavoriteManager();
    
    $accountManager = new AccountManager();
    
    require('view/searchView.php');
}

/**
 * Affiche la liste des jeux pour le genre passée en paramètre dans view/searchView.php.
 *
 * @param string $name_genre Le nom du genre
 */
function searchGamesGenres($name_genre) {
    $gamesManager = new GamesManager();
    $games = $gamesManager->searchGamesGenres($name_genre);
    
    $categorySearch = "les jeux styles ";
    $searchValue = $name_genre;
    
    //favorite
    $favoriteManager = new FavoriteManager();
    
    //Account info
    $accountManager = new AccountManager();
    
    require('view/searchView.php');
}

/**
 * Affiche la liste des jeux pour le théme passée en paramètre dans view/searchView.php.
 *
 * @param string $name_theme
 */
function searchGamesThemes($name_theme) {
    $gamesManager = new GamesManager();
    $games = $gamesManager->searchGamesThemes($name_theme);
    
    $categorySearch = "les jeux dans les thèmes ";
    $searchValue = $name_theme;
    
    //favorite
    $favoriteManager = new FavoriteManager();
    
    //Account info
    $accountManager = new AccountManager();
    
    require('view/searchView.php');
}

/**
 * Affiche la liste des jeux avec le nom passée en paramètre dans view/searchView.php.
 *
 * @param string $game_name
 */
function searchGamesNames($game_name) {
    //Search avec la barre de recherche
    $gameManager = New GamesManager();
    $games = $gameManager->searchGamesName($game_name);
    
    $categorySearch = "la recherche ";
    $searchValue = $game_name;
    
    //favorite
    $favoriteManager = new FavoriteManager();
    
    //Account info
    $accountManager = new AccountManager();
    
    require('view/searchView.php');
    
}

/**
 * Retourne un tableau avec toutes les consoles enregistrées
 *
 * @return array la liste des consoles
 */
function viewConsoles() {
    $gameManager = New GamesManager();
    $consoles = $gameManager->getConsoles();
    
   return $consoles;
}

/**
 * Recherche et liste tous les genres de jeu différents dans la bdd.
 *
 * @return array la liste des genres de jeu
 */
function viewGenres() {
    //Renvoie un tableau avec tous les genres disponible
    $gameManager = New GamesManager();
    $genres = $gameManager->getGenres();
    
    return $genres;
}

/**
 * Fonction test
 */
function viewGenresForConsoles($console) {
    //Affiche tous les genres différent pour la console
    $gameManager = New GamesManager();
    $genres = $gameManager->searchGenresForConsole($console);
    
    
    require('view/zzztestfront.php');  
}

/**
 * Liste les derniers jeux ajoutés dans la bdd
 *
 * @return PDO la liste des nouveaux jeux sortis
 */
function listNewRealease() {
    //retourne les nouvelles sortie;
    $gameManager = New GamesManager();
    $newRealease = $gameManager->getNewRealease()->fetchAll();
    
    return $newRealease;
}












