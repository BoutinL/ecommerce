<?php

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendMailService {
    private $mailer;

    public function __construct(MailerInterface $mailer) {
        $this->mailer = $mailer;
    }

    public function send(string $from, string $to, string $subject, string $template, array $context): void {
        // On crée l'e-mail
        $email = (new TemplatedEmail())
        // La classe TemplatedEmail étend la classe Email.
        // N'hésitez pas à jeter un oeil à cette classe et vous constaterez que les champs suivants correspondent aux propriétés et méthodes qu'elle expose. 
        ->from($from)
        ->to($to)
        ->subject($subject)
        ->htmlTemplate("emails/$template.html.twig")
        ->context($context);
        
        // On envoie l'e-mail
        $this->mailer->send($email);
    }
}