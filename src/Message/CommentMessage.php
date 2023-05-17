<?php

namespace App\Message;

class CommentMessage
{
    public function __construct(
        private int $id,
        private string $context,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getContext(): string
    {
        return $this->context;
    }
}