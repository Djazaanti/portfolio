<?php

declare(strict_types=1);

namespace Oc\Blog\model;

class UserModel
{

    public function listPosts()
    {
        printf('ici affichage des posts :');
    }

    /**
     * - Se connecter à la base de données
     * - Récupérer les utilisateurs
     * @return array d'utilisateurs
     */
    public function getUsers(): array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        $req = $db->prepare('SELECT pseudo FROM user');
        $req->execute();

        return $req->fetchAll();
    }

    /**
     * - Se connecter à la base de données.
     *
     * @return \PDO|null la connexion
     */
    public function dbConnect(): ?\PDO
    {
        try {
            $db = new \PDO('mysql:host=127.0.0.1;port=3307;dbname=blog;charset=UTF8', 'root', '');
            return $db;
        } catch (\PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }


}
