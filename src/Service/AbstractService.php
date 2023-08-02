<?php

namespace App\Service;

use App\Message\CommentMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class AbstractService
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected MessageBusInterface    $bus,
        protected FormService            $formService
    )
    {
    }

    public function form(FormInterface $form, Request $request): void
    {
        $this->formService->createForm($form, $request);
    }

    public function getForm(): FormView
    {
        return $this->formService->getFormView();
    }

    abstract protected function addBrokerMessage(): void;
    abstract protected function saveComment(): void;
    abstract public function dataForm(): bool;
}