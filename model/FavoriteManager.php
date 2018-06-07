<?php

require_once('model/Manager.php');

/**
 * Class FavoriteManager
 *
 * Permets de gérer les favoris des utilisateurs dans la base de données.
 */
class FavoriteManager extends Manager{
    
    /**
     * Fonction utilisée quand l'utilisateur clique sur le bouton de "like" d'un jeu.
     * Si l'utilisateur n'a pas déja ce jeu en favoris, il l'ajout à sa liste.
     * Si l'utilisateur à déjà ce jeu à sa liste, supprime le jeu de ses favoris.
     *
     * @param int $pseudoId  Id de l'utilisateur
     * @param int $gameId  Id du jeu
     *
     * @return bool Si l'action d'ajout a bien fonctionné
     */
    public function InsertFavorite($pseudoId, $gameId) {
        
        $db = $this -> dbConnect();
        
        $reqFavoriteExist = $db->prepare('SELECT * FROM favorites WHERE pseudo_id = ? AND game_id = ?');
        $reqFavoriteExist->execute(array($pseudoId, $gameId));
        $affectedLineFavoriteExist = $reqFavoriteExist->fetch();
        $reqFavoriteExist->closeCursor();
        
        if(!$affectedLineFavoriteExist) {
            $req = $db -> prepare('INSERT INTO favorites(pseudo_id, game_id) VALUES(?,?)');
            $affectedLine = $req -> execute(array($pseudoId, $gameId));
            $req->closeCursor();
        }else {
            $req = $db -> prepare('DELETE FROM favorites WHERE pseudo_id = ? AND game_id = ?');
            $affectedLine = $req -> execute(array($pseudoId, $gameId));
            $req->closeCursor();
        }
        return $affectedLine;
    }
    
    /**
     * Récupère la liste des ID des jeux que l'utilisateur à "liker".
     *
     * @param int $pseudoId  Id de l'utilisateur
     *
     * @return PDO la liste des jeux que l'utilisateur à "liker"
     */
    public function getFavorites($pseudoId) {
        $db = $this -> dbConnect();
        $req = $db->prepare('SELECT game_id FROM favorites WHERE pseudo_id = :id');
        $req->bindValue('id', $pseudoId, PDO::PARAM_INT);
        
        $req->execute();
        
        return $req;
    }
    
    /**
     * Récupère la liste des utilisateurs qui ont "liker" le jeu passé en paramètre.
     *
     * @param int $gameId  Id du jeu
     *
     * @return PDO la liste des utilisateurs qui ont "liker" le jeu
     */
    public function getFavoritesByGames($gameId) {
        $db = $this -> dbConnect();
        $req = $db->prepare('SELECT pseudo_id FROM favorites WHERE game_id = :id');
        $req->bindValue('id', $gameId, PDO::PARAM_INT);
        
        $req->execute();
        
        return $req;
    }
    
    /**
     * Récupère les identifiants et le nombre de "like" des 3 meilleurs "likeur" du site.
     *
     * @return array Une liste avec les Pseudo_id et numb_like des meilleurs "likeur"
     */
    public function getBestLikeurs(){
        //Retourne les 3 meilleurs likeurs du site
        $db = $this->dbConnect();
        $req = $db->query('SELECT `pseudo_id`, COUNT(*) AS numb_like FROM favorites GROUP BY `pseudo_id` ORDER BY numb_like DESC LIMIT 3');
        $req = $req->fetchAll();
        
        return $req;
    }
    
}