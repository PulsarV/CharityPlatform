<?php
namespace AppBundle\Helper;

class EmailSender
{
    private $mailer;
    private $twig;

    public function __construct($host, $port, $encryption, $login, $password, $twig)
    {
        $this->twig = $twig;
        $this->connect($host, $port, $encryption, $login, $password);
    }

    public function connect($host, $port, $encryption, $login, $password)
    {
        if (! $this->mailer) {
            $smtp = \Swift_SmtpTransport::newInstance($host, $port, $encryption)
                ->setUsername($login)
                ->setPassword($password);

            $this->mailer = new \Swift_Mailer($smtp);
        }
    }

    public function send($from, $to, $subject, $template, $twigData, $type = 'text/html')
    {
        $message = \Swift_Message::newInstance()
            ->setSubject($subject)
            ->setFrom($from)
            ->setTo($to)
            ->setBody(
                $this->twig->render($template, $twigData),
                $type
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;

        return $this->mailer->send($message);
    }
}