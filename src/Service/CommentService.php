<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Topics;
use App\Message\CommentMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

class CommentService extends AbstractService
{
    private Comment $comment;

    public function __construct(
        EntityManagerInterface             $entityManager,
        MessageBusInterface                $bus,
        FormService                        $formService,
        private readonly PaginationComment $paginationComment
    )
    {
        $this->comment = new Comment();
        parent::__construct($entityManager, $bus, $formService);
    }

    public function dataForm(Topics $topics = new Topics(), Request $request = new Request()): bool
    {
        if ($this->formService->checkForm()) {
            $this->saveComment($topics);
            $this->addBrokerMessage();
            return true;
        }
        $this->paginationComment->create($request, $topics);
        return false;
    }

    protected function saveComment(Topics $topics = new Topics()): void
    {
        $this->comment->setTopics($topics);
        $this->entityManager->persist($this->comment);
        $this->entityManager->flush();
    }

    protected function addBrokerMessage(): void
    {
        $this->bus->dispatch(new CommentMessage($this->comment->getId(), $this->comment->getText()));
    }

    /**
     * @return Comment
     */
    public function getComment(): Comment
    {
        return $this->comment;
    }

    public function getPagination(): array
    {
        return $this->paginationComment->getPagination();
    }
}