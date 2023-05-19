<?php

namespace App\Message;

use App\Entity\User;

class RegistrationEmailMessage
{
    public function __construct(
        private int $id,
        private User $user,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}