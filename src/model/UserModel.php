<?php

declare(strict_types=1);

namespace Oc\Blog\model;

use PDO;

class UserModel
{
    /**
     * @return \PDO|null
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

    /**
     * @return array
     */
    public function getUsers(): array {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
       
        try { 
            $req = $db->prepare('SELECT * FROM user');
            $req->execute();
    
            return $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION['ErrorMessage'] = $e->getMessage();
        } 
    }
    
    /**
     * @param int $id
     * 
     * @return array
     */
    public function getUser(int $id): array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        
        try {
            $req = $db->prepare('SELECT * FROM user where id = ?');
            $req->execute(array($id));
    
            return $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION['ErrorMessage'] = $e->getMessage();
            return [];
        } 
    }
    
    /**
     * @param string $pseudo
     * 
     * @return array
     */
    public function getUserByPseudo(string $pseudo): array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        try {
            $req = $db->prepare('SELECT * FROM user where pseudo = ?');
            $req->execute(array($pseudo));
            return $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION['ErrorMessage'] = $e->getMessage();
            return [];
        }
    }

    /**
     * @return array
     */
    public function getAdmins(): array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        try {
            $req = $db->prepare('SELECT * FROM user where role = "admin" ');
            $req->execute();
    
            return $req->fetchAll();
        } catch (\PDOException $e) {
            $_SESSION['ErrorMessage'] = $e->getMessage();
            return [];
        }
    }


    /**
     * @param int $id
     * 
     * @return array
     */
    public function getAuthor(int $id): array
    {
        
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        try {
            $req = $db->prepare('SELECT pseudo 
                                 FROM user
                                 WHERE id = ( SELECT user_id 
                                              FROM post
                                              WHERE post.id = ? )');
            $req->execute(array($id));
    
            return $user = $req->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            $_SESSION['ErrorMessage'] = $e->getMessage();
        }

    }

    /**
     * @return int|null
     */
    public function countUsersValidated(): ?int 
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        try {
            $req = $db->prepare('SELECT id FROM user WHERE isValidate=1');
            $req->execute();
            return $users= $req->rowCount();
        } catch (\PDOException $e) {
            $_SESSION['ErrorMessage'] = $e->getMessage();
            return null;
        }
    }
    /**
     * @return int|null
     */
    public function countUsersToValid(): ?int {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        try {
            $req = $db->prepare('SELECT id FROM user WHERE isValidate=0');
            $req->execute();
            return $users= $req->rowCount();
        } catch (\PDOException $e) {
            $_SESSION['ErrorMessage'] = $e->getMessage();
            return null;
        }
    }

    /**
     * @param string $pseudo
     * @param string $email
     * @param string $password
     * 
     * @return void
     */
    public function saveUser(string $pseudo, string $email, string $password): void {
        $db = $this->dbConnect();
        if (null === $db) {
            return;
        }

        try {
            $password_hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $req = $db->prepare('INSERT INTO user(pseudo, email, role, password, isValidate) VALUES(:pseudo, :email, :role, :password_hashed, :isValidate)');
            $req->execute(array(
                'pseudo' => $pseudo, 
                'email' => $email, 
                'role' => "user", 
                'password_hashed' => $password_hashed, 
                'isValidate' => 0
            ));
        } catch (\PDOException $e) {
            $_SESSION['ErrorMessage'] = $e->getMessage();
            return;
        }
    }
}
