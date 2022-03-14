<?php
namespace Oc\Blog\model;

class UserModel{
    
   public function listPosts(){
        printf('ici affichage des posts :');
    }

    public function dbConnect(){
        try{
            $db = new \PDO('mysql:host=127.0.0.1;port=3307;dbname=blog;charset=UTF8', 'root', '');
            return $db;
        }
        catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    public function getUsers(){
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT pseudo FROM user');
        $req->execute();
        $users = $req->fetchAll();
        return $users;
    }



}
