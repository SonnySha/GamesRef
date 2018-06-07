<?php

require_once('model/Manager.php');

/**
 * Class CommentManager
 *
 * Permets de gérer les commentaires de la base de données.
 */
class CommentManager extends Manager {

    /**
     * Compte le nombre de commentaires. Cette fonction est utile pour la pagination des commentaires.
     *
     * @param int $game_id  Id du jeu
     *
     * @return int le nombre de commentaires
     */
    public function numberComments($game_id) {
        $db = $this -> dbConnect();
        $req = $db->prepare('SELECT COUNT(*) FROM comments_games WHERE game_id = ?');
        $affectedLine = $req -> execute(array($game_id));
        
        return $affectedLine;
    }
    
    /**
     * Récupérer les commentaires des utilisateurs.
     *
     * @param int $game_id Id du jeu
     *
     * @return array Tableau avec tous les commentaires
     */
    public function getCommments($game_id) {
        
        $db = $this -> dbConnect();
        $comments = $db->prepare('SELECT * FROM comments_games WHERE game_id = :id ORDER BY comment_date DESC');
        $comments->bindValue('id', $game_id, PDO::PARAM_INT);
        $comments->execute();
        
        $tabComments = $comments->fetchAll();

        return $tabComments;
        
    }
    
    /**
     * Ajouter un commentaire sur un jeux.
     *
     * @param int $game_id Id du jeu
     * @param int $author_id Id de l'auteur du commentaire
     * @param string $comment Commentaire de l'auteur
     *
     * @return bool Si le commentaire est accepté ou non
     */
    public function addComments($game_id,  $author_id, $comment) {
        $db = $this -> dbConnect();
        $postComment = $db->prepare('INSERT INTO comments_games(game_id, author_id, comment, comment_date) VALUES (:game_id,:author_id,:comment,NOW())');
        
        $affectedLine = $postComment->execute(array(
        'game_id' => $game_id,
        'author_id' => $author_id,
        'comment' => $comment));
        
        return $affectedLine;
    }
    
    /**
     * Récupère les commentaires de l'auteur.
     *
     * @param int $author_id Id de l'auteur
     *
     * @return PDO les commentaires de l'auteur
     */
    public function getCommentsForAuthor($author_id) {
        $db = $this -> dbConnect();
        $comments = $db->prepare('SELECT * FROM comments_games WHERE author_id = :id');
        $comments->bindValue('id', $author_id, PDO::PARAM_INT);
        $comments->execute();
        
        return $comments;
    }
    
    /**
     * Récupère la liste des jeux que l'auteur a commentée.
     * Fonction utilisée dans le dahsboard pour lister les commentaires et les jeux que l'auteur a commentés
     *
     * @param int $author_id Id de l'auteur
     *
     * @return PDO La liste des game_id que l'auteur à commenté
     */
    public function getDistinctCommentsForAuthor($author_id) {
        $db = $this -> dbConnect();
        $tabGame_id = $db->prepare('SELECT DISTINCT game_id FROM comments_games WHERE author_id = :id');
        $tabGame_id->bindValue('id', $author_id, PDO::PARAM_INT);
        $tabGame_id->execute();

        return $tabGame_id;
    }
    
    /**
     * Récupère les identifiants et le nombre de commentaires des 3 meilleurs commentateurs du site.
     *
     * @return array Une liste avec les Author_id et numb_comments des meilleurs commentateurs
     */
    public function getBestCommentators() {
        //Retourne les 3 premiers commentateurs
        $db = $this->dbConnect();
        $req = $db->query('SELECT `author_id`, COUNT(*) AS numb_comments FROM comments_games GROUP BY `author_id` ORDER BY numb_comments DESC LIMIT 3');
        $req = $req->fetchAll();
        
        return $req;
    }
    
}
