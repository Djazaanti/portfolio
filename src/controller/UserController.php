<?php
namespace Oc\Blog\controller;
use Oc\Blog\model\UserModel;
use Twig\Loader\FilesystemLoader;

class UserController
{
    private $loader;
    protected $twig;

    public function _construct()
    {
        $this->loader = new FilesystemLoader('./templates');
    }
    

    public function displayText(){
        printf("hello de UserController() \n ");
    } 

}