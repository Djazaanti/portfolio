<?php 
namespace Oc\Blog\model;

class Model{
    protected function __construct(){
        
     /**
     * - Se connecter à la base de données.
     *
     * @return \PDO|null la connexion
     */
        try {
            $db = new \PDO('mysql:host=127.0.0.1;port=3307;dbname=blog;charset=UTF8', 'root', '');
            return $db;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}