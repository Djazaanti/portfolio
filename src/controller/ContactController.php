<?php
declare(strict_types=1);

namespace Oc\Blog\controller;

use Oc\Blog\service\TwigService;
use Oc\Blog\controller\UserController;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

class ContactController
{
    /**
     * @var TwigService Twig
     */
    private TwigService $twigService;

    /**
     * @var ContactModel The contact model to make request
     */
    private ContactModel $contactModel;

    /**
     * Le constructeur de la classe ContactController.
     * Il attend en paramètre twig pour afficher les vues
     * @param TwigService $twigService
     */
    public function __construct(TwigService $twigService)
    {
        // Je stock la configuration du service twig dans notre variable twig du controller
        $this->twigService = $twigService;
    }

    private function validInput(string $data) {
        return htmlspecialchars($data);
    }

    private function sendEmail(string $name, string $lastname, string $email, string $message) : bool {

        // send mails with PHPMailer
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPAuth = 1;
        // $mail->SMTPDebug = 1;
        
        if (!$mail->SMTPAuth) {
            return false;
        }
        
        $mail->SMTPSecure = 'ssl';
        $mail->Username = 'alidjazaanti1@gmail.com';
        $mail->Password = 'fsytpduoqnbzitlc';

        $mail->CharSet = 'UTF-8';

        if (!$mail->smtpConnect()) {
            return false;
        }

        $mail->From = $email;
        $mail->FromName = $name.'.'.$lastname;

        $mail->Subject = 'Formulaire de contact';
        $mail->WordWrap = 50;
        $mail->MsgHTML('<div>'.$message.'</div>');
        $mail->isHTML(true);
        $mail->addAddress('alidjazaanti1@gmail.com', 'Djazaanti');

        return $mail->send();
    }

    public function submitFormContact($name, $lastname, $email, $message)
    {
        $nameValid = $this->validInput($name);
        $lastnameValid = $this->validInput($lastname);
        $messageValid = $this->validInput($message);
        $emailValid = filter_var($email, FILTER_VALIDATE_EMAIL);

        // check email format. If not valid we send error message
        if (false === $emailValid) {
            $_SESSION['flash'] = 'error';
            $_SESSION['flash_message'] = 'Une erreur est survenue. Veuillez vérifier votre email.';
        }

        $isEmailSended = $this->sendEmail($nameValid, $lastnameValid, $emailValid, $messageValid);
        if ($isEmailSended == false) {
            $_SESSION['flash'] = 'error';
            $_SESSION['flash_message'] = "Une erreur est survenue. L'e-mail n'a pas pu être envoyé.";
        } else {
            $_SESSION['flash'] = 'success';
            $_SESSION['flash_message'] = 'Votre email a bien été envoyé';
        }

        // After sending email we redirect to homepage with contact anchor
        echo $this->twigService->get()->render('templates/message.html.twig');

        header('Location: ../index.php?contact');
        exit();
    }
}