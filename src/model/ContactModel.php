<?php

declare(strict_types=1);

namespace Oc\Blog\model;

class ContactModel
{
    /*public function __construct(){
    }*/

    /**
     * @return \PDO|null
     */
    public function dbConnect(): ?\PDO
    {
        try {
            $db = new \PDO('mysql:host=127.0.0.1;port=3307;dbname=blog;charset=UTF8', 'root', '');
            return $db;
        }
        catch (\PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }

    public function insertFormContact($name, $email, $tel, $message){
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }
        try{
            $req = $db->prepare("INSERT INTO contact(name, lastname, email, message, sendAt) VALUES(?, ?, ?, ?, NOW())");
            $savedContact = $req->execute(array($name, $lastname, $email, $message));
            return $savedContact;
        }
        catch (\PDOException $e) {
            echo $e->getMessage();
            return null;
        }
    }
}