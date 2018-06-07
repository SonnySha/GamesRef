<?php

require_once('model/Manager.php');

/**
 * Class GamesManager
 *
 * Permets de gérer les jeux.
 * Récupérer les informations, faire des recherches.
 */
class GamesManager extends Manager {
    /**
     * Récupère les informations du jeu sélectionné.
     *
     * @param int $gameId  Id du jeu
     *
     * @return array la liste des informations du jeu
     */
    public function getGame($gameId) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM games WHERE id = ?');
        $req->execute(array($gameId));
        $game = $req->fetch();
        
        return $game;
    }
    
    /**
     * Récupère tous les jeux enregistrés dans la bdd.
     *
     * @return PDO La listes des jeux
     */
    public function getGames() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM games ORDER BY id');
        
        return $req;
    }
    
    /**
     * Recherche et liste toutes les consoles différentes dans la bdd.
     *
     * @return array la liste des consoles
     */
    public function getConsoles() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT consoles FROM `games`'); //Récupére tous les champs consoles
        
        
        
        $ligneConsole = ""; //Variable qui contiendra toutes les consoles concaténées en une ligne
        while($AllConsoles = $req->fetch()) { //Boucle qui concaténe le tableau sur une ligne dans la variable $ligneConsole
            $ligneConsole = $ligneConsole . " " . $AllConsoles['consoles'];
        }
        
        $tabAllConsoles = explode(" ", $ligneConsole); //Coupe chaque élément de $ligneConsole à chaque espace et ajoute chaque élément dans un array
        
        $tabUniqueConsoles = array_unique($tabAllConsoles); //Efface les doublons du tableau. Nous avons maintenant un tableau avec des élements unique, nous avons donc la liste de toutes les consoles enregistrées dans la bdd
        
        
        
        unset($tabUniqueConsoles[0]); // Supprime $tabUniqueConsole[0] car c'est un espace
        
        $tabUniqueConsoles = array_values($tabUniqueConsoles); //retourne les valeurs du tableau $tabUniqueConsoles et l'indexe de facon numérique. 
        
        //$tabUniqueConsoles commencera a l'index 1
        return $tabUniqueConsoles;
    }
    
    /**
     * Recherche et liste tous les genres de jeu différents dans la bdd.
     *
     * @return array la liste des genres de jeu
     */
    public function getGenres(){
        //Même principe que getConsoles()
        $db = $this->dbConnect();
        $req = $db->query('SELECT genres FROM `games`');
        
        $ligneGenres = "";
        while($bb = $req->fetch()) {
            $ligneGenres = $ligneGenres . " " . $bb["genres"];
        }
        
        $tabAllGenres = explode(" ", $ligneGenres);
        
        $tabUniqueGenres = array_unique($tabAllGenres);
        
        unset($tabUniqueGenres[0]);
        
        $tabUniqueGenres = array_values($tabUniqueGenres);
        
        
        return $tabUniqueGenres;
    }
    
    /**
     * Liste les derniers jeux ajoutés dans la bdd
     *
     * @return PDO la liste des nouveaux jeux sortis
     */
    public function getNewRealease() {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM `games` ORDER BY `launch_date` DESC');
        return $req;
    }
    
    /**
     * Rechercher les jeux enregistrés sur la console passée en paramètre.
     *
     * @param string $name_console  Nom de la console
     *
     * @return PDO la liste des jeux enregistrés pour cette console
     */
    public function searchGamesConsoles($name_console) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM games where consoles LIKE :value');

        $req->execute(array(':value' => '%' . $name_console . '%'));
        
        
        return $req;
    }
    
    /**
     * Rechercher les jeux enregistrés pour le genre passé en paramètre.
     *
     * @param string $name_genre nom du genre
     *
     * @return PDO la liste des jeux enregistrés pour ce genre
     */
    public function searchGamesGenres($name_genre) {
    $db = $this->dbConnect();
    $req = $db->prepare('SELECT * FROM games where genres LIKE :value');

    $req->execute(array(':value' => '%' . $name_genre . '%'));
        
    return $req;
    }
    
    /**
     * Rechercher les jeux enregistrés pour le théme passé en paramètre.
     *
     * @param string $name_theme nom du théme
     *
     * @return PDO la liste des jeux enregistrés pour ce théme
     */
    public function searchGamesThemes($name_theme) {
    $db = $this->dbConnect();
    $req = $db->prepare('SELECT * FROM games where themes LIKE :value');

    $req->execute(array(':value' => '%' . $name_theme . '%'));
          
    return $req;
    }
    
    /**
     * Rechercher les jeux enregistrés par titre/name.
     *
     * @param string $name_game nom du jeu
     *
     * @return PDO la liste des jeux avec ce nom
     */
    public function searchGamesName($name_game) {
    $db = $this->dbConnect();
    $req = $db->prepare('SELECT * FROM games WHERE name LIKE :value');
    $req->execute(array('value' => '%' . $name_game . '%' ));
        
    return $req;
    }
    

    /**
     * Recherche et liste tous les genres disponibles par rapport à la console.
     * Fonction utilisé dans la barre de navigation pour lister les genres disponibles pour chaque console.
     *
     * @param string $console nom de la console
     *
     * @return array la liste des différents genres pour cette console
     */
    public function searchGenresForConsole($console) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT genres FROM games WHERE consoles LIKE :console');
        $req->execute(array('console' => '%' . $console . '%' ));
        
        $ligneGenres = "";
        while($genre = $req->fetch()) {
            $ligneGenres = $ligneGenres . " " . $genre['genres'];
        }
        
        //Même principe que getConsoles()

        $tabAllGenres = explode(" ", $ligneGenres);
        

        $tabUniqueGenres = array_unique($tabAllGenres);
        
        unset($tabUniqueGenres[0]);
        
        $tabUniqueGenres = array_values($tabUniqueGenres);
        
        return $tabUniqueGenres;
        
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}
