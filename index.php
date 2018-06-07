<?php
    
    //Test des GET et POST
    //var_dump($_GET);
    //var_dump($_POST);
    
    require('controller/controllerGames.php');
    require('controller/controllerAccount.php');
    require('controller/controllerComment.php');
    require('controller/controllerFavorite.php');
    require('controller/controllerDashboard.php');
    
    //Démarrer la session pour connecter l'utilisateur à son compte automatiquement
    session_start();

try {
    
    

    
    if(isset($_GET['action'])) {
        if($_GET['action'] == 'listGames') {
            listGames();
        }elseif(isset($_GET['id'])) { //Si le GET "id" existe alors nous voulons consulter une page de jeux
            
            if($_GET['id'] > 0 && $_GET['action'] == 'game'){ //Vérifie que l'id soit bon et qu'on veuille bien regarder un Jeux
                viewGame($_GET['id'], $_GET['page']); // Lance la fonction viewGame et affiche la fiche technique du jeux controller/controllerGames
            }
        }elseif($_GET['action'] == 'search') { //Rechercher un jeux grâce à son théme, console ou genre
            if(isset($_GET['standard']) && isset($_GET['value'])) {
                if($_GET['standard'] == 'consoles') {
                    searchGamesConsoles(htmlspecialchars($_GET['value']));
                } elseif($_GET['standard'] == 'genres') {
                    searchGamesGenres(htmlspecialchars($_GET['value']));
                } elseif($_GET['standard'] == 'themes') {
                    searchGamesThemes(htmlspecialchars($_GET['value']));
                }         
            } 
            
        }elseif($_GET['action'] == 's'){ // Rechercher un jeux grâce à la barre de recherche
            if(isset($_POST['searchBar']) && !empty($_POST['searchBar'])) {
                searchGamesNames(htmlspecialchars($_POST['searchBar']));
            }else {
                throw new Exception('Erreur : votre recherche n\'est pas valide');
            }
            
        //Account Connection 
        }elseif($_GET['action'] == 'connection' && isset($_POST['pseudo-connection']) && isset($_POST['password-connection'])) {
           if(!empty($_POST['pseudo-connection']) && !empty($_POST['password-connection'])){
            Connection(htmlspecialchars($_POST['pseudo-connection']), htmlspecialchars($_POST['password-connection']), true);
           }else {
               throw new Exception('Erreur, tous les champs de connexion ne sont pas remplis');
           }
        //Account registration
        }elseif($_GET['action'] == 'registration' && isset($_POST['pseudo']) && isset($_POST['password1']) && isset($_POST['password2'])) {
            if(!empty($_POST['pseudo']) && !empty($_POST['password1']) && !empty($_POST['password2'])) {
                addAccount(htmlspecialchars($_POST['pseudo']), htmlspecialchars($_POST['password1']), htmlspecialchars($_POST['password2']));  
            } else {
                throw new Exception('Erreur, tous les champs d\'enregistrements ne sont pas remplis');
            }
        
        }elseif($_GET['action'] == 'connection') { //Affiche la page de connection
            pageConnection();
        }elseif($_GET['action'] == 'registration') { //Affiche la page d'enregistrement
            pageRegistration();
            
        
        }elseif($_GET['action'] == 'addFavorite') { //Ajout un jeux au favoris du joueur
            addFavorite(htmlspecialchars($_GET['pseudoId']), htmlspecialchars($_GET['gameId']));
            
        
        }elseif($_GET['action'] == 'dashboard') { //Accéder à son propre Dashboard
            MyDashboard();
            
        }elseif($_GET['action'] == 'disconnect') { //Se déconnecter
            disconnect();
        }elseif($_GET['action'] == 'tuto') { //Voir le tuto du site (pas encore construit)
            require('view/tutoView.php');
        }elseif($_GET['action'] == 'home') {
            
        }
    
    
    
        
        
        
        
        
    } else {//Si aucune des actions n'est demandée alors montrer la page d'accueil
        require('view/homeView.php');
    }
    
    if(isset($_GET['action'])) {
        if($_GET['action'] == 'addComment') { //Ajouter un commentaire
            if(!empty($_POST['comment']) && isset($_GET['id'])) {
                addComment(htmlspecialchars($_GET['id']), htmlspecialchars($_POST['comment'])); //Ajoute le commentaire de l'utilisateur connecté
            } else {
                throw new Exception('Erreur, votre commentaire est vide !');
            }
        }
    }
    
    //Visionner le Dashboard d'un autre utilisateur
    if(isset($_GET['action'])){
        if($_GET['action'] == 'viewdashboard' && isset($_GET['id'])) {
            viewDashboard(htmlspecialchars($_GET['id']));
        }
    }
    
    

} catch(Exception $e) {
    $descriptioneError = $e->getMessage();
    require('view/errorView.php');
}


?>

