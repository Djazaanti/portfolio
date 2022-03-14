<?php
require_once('vendor/autoload.php');
use Oc\Blog\controller\UserController;
use Oc\Blog\model\UserModel;

$controller = new UserController();
$controller->displayText();

$UserModel = new UserModel();
$listPosts = $UserModel->listPosts();
$users = $UserModel->getUsers();

$i = 0;
foreach($users as $user){
    echo "$user[pseudo]";
}

