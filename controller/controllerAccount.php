<?php

require_once('model/AccountManager.php');

/**
 * Ajout d'un nouveau compte.
 *
 * @param string $pseudo Le pseudo du nouvel utilisateur
 * @param string $password1 Le mot de passe du nouvel utilisateur
 * @param string $password2 Le mot de passe réécrit du nouvel utilisateur
 *
 */
function addAccount($pseudo, $password1, $password2) {
    $accountManager = new AccountManager;
    
    $pseudoExist = $accountManager->pseudoExist($pseudo); //Regarde si un pseudo similaire existe
    
    if($password1 != $password2) {
        throw new Exception("Les mots de passe entrés ne sont pas identiques.");
    }
    
    if($pseudoExist > 0) { //Action en fonction de l'existence d'un pseudo similaire
        throw new Exception("Le pseudo < " . $pseudo . " > existe déjà.");
    } else {
        $accountManager->addAnAccount($pseudo, $password1);
        
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['password'] = $password1;
        
        $pseudoAccount = $pseudo;
        $avatarAccount = 'basique.png';
        
        require('view/accountCreateSuccess.php');
   
    }
    
}

/**
* Récupère les infos de l'utilisateur par rapport à son id.
*
* @param int $id l'Id du compte
*
* @return array tableau avec les informations du compte
*/
function getInfoById($id) {
    $accountManager = new AccountManager;
    $infos = $accountManager->getInfoById($id);
    
    return $infos;
}

/**
* Reconduit l'utilisateur vers la page de connexion.
*/
function pageConnection() {
    require('view/connectionView.php');
}

/**
* Reconduit l'utilisateur vers la page d'inscription'.
*/
function pageRegistration() {
    require('view/registrationView.php');
}

/**
* Connecte l'utilisateur sur son compte.
*
* @param string $pseudo Le pseudo du compte
* @param string $password Le mot de passe du compte
* @param bool $errorMessage Affiche un message d'erreur si la connexion à échoué 
*/
function Connection($pseudo, $password, $errorMessage = true) {
    $accountManager = new AccountManager;
    $AccountExist = $accountManager->connexionAccount($pseudo, $password);
    
    if(!$AccountExist) {
        if($errorMessage == true) {
            throw new Exception("Impossible de se connecter, mot de passe ou pseudo inexistant.");
        }
    } else {
        $_SESSION['pseudo'] = $pseudo;
        $_SESSION['password'] = $password;
        header('Location: http://localhost/gamesRef/action/listGames/1');
    }
}

/**
* Déconnecte l'utilisateur de son compte
*
*/
function disconnect() {
    $_SESSION = array();
    session_destroy();
	header('Location: http://localhost/gamesRef/action/listGames/1');
    //header('Location: http://www.sonnyweb.fr/gamesRef/action/listGames/1');
}
