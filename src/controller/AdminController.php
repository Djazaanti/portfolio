<?php

declare(strict_type=1);

namespace OC\Blog\controller;

use OC\Blog\service\TwigService;
use Twig\error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use OC\Blog\model\UserModel;

class AdminController{

    private TwigService $twigService;

    public function __construct(TwigService $twig){
        // Je stock la configuration du service twig dans notre variable twig du controller
        $this->twigService = $twig;
    }

    /**
     * @return void
     */
    public function allAdmins() : void {
        $userModel = new UserModel();
        $admins = $userModel->getAdmins();

        echo $this->twigService->get()->render('dashboard.html.twig', ['admins' => $admins]);
    }

}