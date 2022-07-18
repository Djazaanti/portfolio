<?php
declare(strict_types=1);

namespace Oc\Blog\controller;

use Oc\Blog\service\TwigService;
use Oc\Blog\controller\UserController;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

class ContactController
{
    /**
     * @var TwigService Twig
     */
    private TwigService $twigService;

    /**
     * @param TwigService $twigService
     */
    public function __construct(TwigService $twigService)
    {
        $this->twigService = $twigService;
    }

    /**
     * @param string $data
     * 
     * @return string
     */
    private function validInput(string $data) : string {
        return htmlspecialchars($data);
    }

    /**
     * @param string $name
     * @param string $lastname
     * @param string $email
     * @param string $message
     * 
     * @return bool
     */
    private function sendEmail(string $name, string $lastname, string $email, string $message) : bool {

        // send mails with PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPAuth = 1;
        
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
        $mail->MsgHTML('<div><p>Nom : '.$name.'</p><p>Prénom : '.$lastname.'</p><p>'.'</p><p>Message : '.$message.'</p><p>Répondre à : '.$email.'</p></div>');
        $mail->isHTML(true);
        $mail->addAddress('alidjazaanti1@gmail.com', 'Djazaanti');

        return $mail->send();
    }

    /**
     * @param string $name
     * @param string $lastname
     * @param string $email
     * @param string $message
     * 
     * @return void
     */
    public function submitFormContact(string $name, string $lastname, string $email, string $message) : void
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
        if ($isEmailSended === false) {
            $_SESSION['flash'] = 'error';
            $_SESSION['flash_message'] = "Une erreur est survenue. L'e-mail n'a pas pu être envoyé.";
        } else {
            $_SESSION['flash'] = 'success';
            $_SESSION['flash_message'] = 'Votre email a bien été envoyé';
        }
        
        header('Location: index.php?contact#contact');
    }
}
