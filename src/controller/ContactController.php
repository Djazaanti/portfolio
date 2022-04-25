<?php
declare(strict_types=1);

namespace Oc\Blog\controller;


use Oc\Blog\service\TwigService;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Oc\Blog\model\ContactModel;

class ContactController{
     /**
     * @var TwigService Twig
     */
    private TwigService $twigService;
    protected ContactModel  $contactModel;

    /**
     * Le constructeur de la classe UserController.
     * Il attend en paramètre twig pour afficher les vues
     * @param TwigService $twig Le service twig
     */
    public function __construct(TwigService $twigService)
    {
        // Je stock la configuration du service twig dans notre variable twig du controller
        $this->twigService = $twigService;
    }
    public function submitFormContact($name, $lastname, $email, $message){
        $submitContact = $contactModel->insertFormContact($name, $lastname, $email, $message);
        if ($submitContact === false) {
            // die('Impossible d\'enregistrer ce formulaire de contact !');
            $this->twigService->get()->render('contactSection.html.Twig', "impossible d\'enregistrer ce formulaire de contact ! ");
        }
        else {
            
            echo $this->twigService->get()->render('contactSection.html.Twig', ['emailcontact' => $email] );
        }
    }

}