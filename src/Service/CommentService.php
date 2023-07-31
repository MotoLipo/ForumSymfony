<?php

namespace App\Service;

use App\Entity\Comment;
use App\Entity\Topics;
use App\Message\CommentMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

class CommentService
{
    private Comment $comment;
    private Request $request;

    public function __construct(
        private EntityManagerInterface $entityManager,
        private MessageBusInterface    $bus,
        private FormComment $formComment,
        private PaginationComment $paginationComment
    )
    {
        $this->comment = new Comment();
    }

    public function form(FormInterface $form, Request $request): void
    {
        $this->formComment->createForm($form, $request);
        $this->request = $request;
    }

    public function dataForm(Topics $topics): bool
    {
        if ($this->formComment->checkForm()) {
            $this->saveComment($topics);
            $this->addBrokerMessage();
            return true;
        }
        $this->paginationComment->create($this->request, $topics);
        return false;
    }

    private function saveComment(Topics $topics): void
    {
        $this->comment->setTopics($topics);
        $this->entityManager->persist($this->comment);
        $this->entityManager->flush();
    }

    private function addBrokerMessage(): void
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

    public function getForm(): FormView
    {
        return $this->formComment->getFormView();
    }

    public function getPagination(): array
    {
        return $this->paginationComment->getPagination();
    }
}