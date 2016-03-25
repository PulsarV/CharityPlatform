<?php

namespace AppBundle\Controller\Common;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index_page")
     */
    public function indexAction()
    {
        return $this->redirectToRoute('charity_index');
    }

    /**
     * @Route("/test-mail", name="test_mail")
     */
    public function sendTestMailAction()
    {
        $mail = $this->get('mail');
        $mailSender = 'gh.charity.supp@gmail.com';
        $targetMail = 'workbel14@gmail.com';
        $mailTitle = 'Yea! Test mail!';
        $mail->send(
            $mailSender,
            $targetMail,
            $mailTitle,
            'AppBundle:Emails:testmail.html.twig',
            array(
                'mailsender' => $mailSender
            )
        );
        return $this->redirectToRoute('charity_index');
    }
}
