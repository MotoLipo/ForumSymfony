<?php

namespace App\Service;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

class FormComment
{
    private FormInterface $form;

    public function createForm(FormInterface $form, Request $request): void
    {
        $this->form = $form;
        $this->form->handleRequest($request);
    }

    public function checkForm(): bool
    {
        if ($this->form->isSubmitted() && $this->form->isValid()) {
            return true;
        }
        return false;
    }

    public function getFormView(): FormView
    {
        return $this->form->createView();
    }
}