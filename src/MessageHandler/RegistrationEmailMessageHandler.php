<?php

namespace App\MessageHandler;

use App\Message\RegistrationEmailMessage;
use App\Security\EmailVerifier;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Mime\Address;

#[AsMessageHandler]
class RegistrationEmailMessageHandler
{
    public function __construct(
        private EmailVerifier $emailVerifier,
    ) {
    }

    public function __invoke(RegistrationEmailMessage $message)
    {
        $user = $message->getUser();
        $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            (new TemplatedEmail())
                ->from(new Address('megadobro030@gmail.com', 'Андрей'))
                ->to($user->getEmail())
                ->subject('Пожалуйста подтвердите свою электронную почту')
                ->htmlTemplate('registration/confirmation_email.html.twig')
        );
    }
}