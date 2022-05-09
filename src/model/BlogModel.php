<?php
declare(strict_types=1);

namespace Oc\Blog\src\controller;

class BlogModel{
   
     /**
     * @return array
     */
    public function getUsers() : array
    {
        $db = $this->dbConnect();
        if (null === $db) {
            return [];
        }

        $req = $db->prepare('SELECT pseudo FROM user');
        $req->execute();

        return $req->fetchAll();
    }
}