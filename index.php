<?php
require_once('vendor/autoload.php');
use Oc\Blog\controller\UserController;
use Oc\Blog\model\UserModel;
use Oc\Blog\controller\TwigService;

$twigService = new TwigService(); 
$controller = new UserController($twigService);

// On veut afficher les utilisateurs
$users = $controller->showUsers();
foreach($users as $user){
echo "$user[pseudo]";
}