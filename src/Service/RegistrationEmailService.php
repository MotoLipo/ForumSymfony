<?php

namespace App\Service;

use App\Entity\User;
use App\Message\RegistrationEmailMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegistrationEmailService extends AbstractService
{
    private User $user;
    private bool $modal = false;

    public function __construct(
        EntityManagerInterface                       $entityManager,
        MessageBusInterface                          $bus,
        FormService                                  $formService,
        private readonly UserPasswordHasherInterface $userPasswordHasher
    )
    {
        $this->user = new User();
        parent::__construct($entityManager, $bus, $formService);
    }

    protected function addBrokerMessage(): void
    {
        $this->bus->dispatch(new RegistrationEmailMessage($this->user->getId(), $this->user));
    }

    protected function saveComment(): void
    {
        $this->user->setPassword(
            $this->userPasswordHasher->hashPassword(
                $this->user,
                $this->formService->getForm()->get('plainPassword')->getData()
            )
        );
        $this->user->setRoles(['ROLE_USER']);

        $this->entityManager->persist($this->user);
        $this->entityManager->flush();
    }

    public function dataForm(): bool
    {
        if ($this->formService->checkForm()) {
            $this->saveComment();
            $this->addBrokerMessage();
            $this->modal = true;
            return true;
        }
        return false;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return bool
     */
    public function isModal(): bool
    {
        return $this->modal;
    }

}