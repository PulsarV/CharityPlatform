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
        $mail = $this->get('app.mail_sender');
        $mailAuthor = 'gh.charity.supp@gmail.com';
        $targetMail = 'workbel14@gmail.com';
        $mailTitle = 'Yea! Test mail!';
        $mail->send(
            $mailAuthor,
            $targetMail,
            $mailTitle,
            'AppBundle:Emails:testmail.html.twig',
            array(
                'mailauthor' => $mailAuthor
            )
        );
        return $this->redirectToRoute('charity_index');
    }
}
