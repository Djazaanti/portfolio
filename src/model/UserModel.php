<?php

declare(strict_types=1);

namespace Oc\Blog\model;

use PDO;

class UserModel
{
    /**
     * @return \PDO|null
     */
    public function dbConnect() : ?\PDO
    {
        try {
            $db = new \PDO('mysql:host=127.0.0.1;port=3307;dbname=blog;charset=UTF8', 'root', '');
            return $db;
        } catch (\PDOException $e) {
            echo $e->getMessage();

            return null;
        }
    }
    
    /**
     * @param int $id
     * 
     * @return array
     */
    public function getUser(int $id) : array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        
        $req = $db->prepare('SELECT * FROM user where id = ?');
        $req->execute(array($id));

        return $user = $req->fetch(PDO::FETCH_ASSOC);
    }

     /**
     * @return array
     */
    public function getUserByPseudo(string $pseudo) : array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        $req = $db->prepare('SELECT * FROM user where pseudo = ?');
        $req->execute(array($pseudo));

        return $req->fetch(PDO::FETCH_ASSOC);
    }
}