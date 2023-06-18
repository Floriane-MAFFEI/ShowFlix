<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MyMailerService{

    // ! Dependency injection of the mailer service
    private $mailer;

    // ! The admin email address can be manually configured as a parameter
    private $adminMail;

    public function __construct(MailerInterface $mailer, string $adminMail)
    {
        $this->mailer = $mailer;
        $this->adminMail = $adminMail;
    }

    /**
     * method that use the mailerInterface to send an email
     * 
     * @param string $subject Title of the mail
     * @param string $template The template
     * @param array $context variables needed by the template
     */
    public function send(string $subject, string $template, array $context){
        // Create a new TemplatedEmail object
        $email = (new TemplatedEmail())
            // Set the sender email address (you should put your Mailjet email here)
            ->from($this->adminMail)
            // Set the recipient email address
            ->to($this->adminMail)
            // Set the subject of the email
            ->subject($subject)
            // Set the HTML template as the email content
            ->htmlTemplate($template)

            // Pass variables to the template using the "context" method
            ->context($context);

    }

}