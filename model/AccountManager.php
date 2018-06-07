<?php

require_once('model/Manager.php');

/**
 * Class AccountManager
 *
 * Permets de gérer les comptes de la base de données
 * Voir si un pseudo existe/ voir les infos du compte/ Ajouter un compte et connecter un compte
 */

class AccountManager extends Manager {
    
    /**
     * Regarde si un pseudo porte le même nom dans la BDD.
     * @param string $pseudo  Le pseudo
     *
     * @return int nombre de pseudo qui porte ce nom
     */
    public function pseudoExist($pseudo) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM account WHERE pseudo = :pseudo');
        $req->execute(array('pseudo' => $pseudo));
        
        $affectedLine = $req->fetch();
        return $affectedLine;
    }
    
    /**
     * Récupérer toutes les informations du pseudo grâce à son PSEUDO dans la BDD.
     *
     * @param string $pseudo  Le pseudo sur lequel on veut connaître les informations
     *
     * @return array Toutes les informations du pseudo
     */
    public function infoAccount($pseudo) {
            $db = $this->dbConnect();
            $req = $db->prepare('SELECT * FROM account WHERE pseudo = :pseudo');
            $req->execute(array('pseudo' => $pseudo));
            $affectedLine = $req->fetch();
            
        return $affectedLine;
    }    
    
    /**
     * Récupére toutes les infos du pseudo grâce à son ID dans la BDD.
     *
     * @param int $id  L'Id du pseudo sur lequel on veut connaître les informations
     *
     * @return array Toutes les informations du pseudo
     */
    public function getInfoById($id) {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM account WHERE id = :id');
        $req->execute(array('id' => $id));
        $affectedLine = $req->fetch();
            
        return $affectedLine;
    }
    
    /**
     * Ajoute un nouveau compte dans la BDD.
     *
     * @param string $pseudo  Le pseudo du compte
     *
     * @return array Toutes les informations du pseudo
     */
    public function addAnAccount($pseudo, $password) {
       $pass_hache = password_hash($password, PASSWORD_DEFAULT); // hachage du mot de passe pour plus de sécurité
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO account(avatar, pseudo, password, signature, inscription_date, authorization) VALUES (:avatar, :pseudo, :password, :signature, CURDATE(), :authorization)');
        $affectedLine = $req->execute(array(
        'avatar' => 'basique.png',
        'pseudo' => $pseudo,
        'password' => $pass_hache,
        'signature' => 'pas de signature',
        'authorization' => '0'));

        return $affectedLine;
    }
    
    /**
     * Connecte l'utilisateur à son compte.
     *
     * @param string $pseudo  Le pseudo du compte
     * @param string $password  Le mot de passe du compte
     *
     * @return bool Les informations sont exactes ou pas
     */
    public function connexionAccount($pseudo, $password) {
        $pass_hache = password_hash($password, PASSWORD_DEFAULT);
        $db = $this->dbConnect();
        $pass_exist = $db->prepare('SELECT password FROM account WHERE pseudo= :pseudo');
        $pass_exist->execute(array('pseudo' => $pseudo));
        $resultat = $pass_exist->fetch();
        $resultat2 = password_verify($password,$resultat['password']);
        
        return $resultat2;
        
    }
    
}
