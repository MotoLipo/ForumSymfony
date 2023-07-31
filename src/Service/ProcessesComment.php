<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Topics;
use App\Message\CommentMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class ProcessesComment
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MessageBusInterface    $bus
    )
    {
    }

    public function processes(Comment $comment, Topics $topics): void
    {
        $this->saveComment($comment,$topics);
        $this->addBrokerMessage($comment);
    }

    private function saveComment(Comment $comment, Topics $topics): void
    {
        $comment->setTopics($topics);
        $this->entityManager->persist($comment);
        $this->entityManager->flush();
    }

    private function addBrokerMessage(Comment $comment): void
    {
        $this->bus->dispatch(new CommentMessage($comment->getId(), $comment->getText()));
    }
}