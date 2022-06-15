<?php

declare(strict_type=1);

namespace OC\Blog\controller;

use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

use Oc\Blog\model\CommentModel;

class DashboardController{
    /**
     * @var TwigService Twig
     */
    private TwigService $twigService;

    /**
     * @param TwigService $twigService
     */
    public function __construct(TwigService $twigService)
    {
        // Je stock la configuration twig dans notre variable twig du controller
        $this->twigService = $twigService;
    }

    
    /**
     * @return void
     */
    public function dashboardPage() : void
    {
        echo $this->twigService->get()->render('admin/dashboard.html.twig');
    }

    /**
     * @return void
     */
    public function commentairesEnAttente() : void {

        $commentModel = new CommentModel();
        $commentaires = $commentModel->getCommentairesEnAttente();

        echo $this->twigService->get()->render('dashboard.html.twig', ['commentaires' => $commentaires ]);
    }
}
