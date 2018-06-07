<?php

class Manager {
    
    protected function dbConnect() {
        //$db = new PDO('mysql:host=sonnywebqfadmin.mysql.db;dbname=sonnywebqfadmin;charset=utf8', 'sonnywebqfadmin', '1dataSoso');
        $db = new PDO('mysql:host=localhost;dbname=ynnosgames;charset=utf8', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        return $db;
    }
    
}



?>