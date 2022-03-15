<?php
require_once('vendor/autoload.php');
use Oc\Blog\controller\UserController;
use Oc\Blog\model\UserModel;
use Oc\Blog\controller\TwigService;

$controller = new UserController($TwigService);
$TwigService = new TwigService(); 

// On veut afficher les utilisateurs
$controller->showUsers();

//$controller->displayText();

//$UserModel = new UserModel();
//$UserModel->listPosts();
//$users = $UserModel->getUsers();
//
//$i = 0;
//foreach($users as $user){
//    echo "$user[pseudo]";
//}