<?php

namespace App\Service;


class Email
{
    public $mailer;
    public $view;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $view)
    {
        $this->mailer = $mailer;
        $this->view = $view;
    }

    public function enviar(string $assunto, array $destinatario, string $template, array $params)
    {
        $mensagem = (new \Swift_Message($assunto))
            ->setFrom('noreply@email.com')
            ->setTo($destinatario)
            ->setBody($this->view->render($template, $params), 'text/html');

        $this->mailer->send($mensagem);
    }
}