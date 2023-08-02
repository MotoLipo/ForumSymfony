<?php

namespace App\Controller;

use App\Entity\Topics;
use App\Form\CommentFormType;
use App\Repository\TopicsRepository;
use App\Service\CommentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(TopicsRepository $topicsRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'topics' => $topicsRepository->findAll(),
        ]);
    }

    #[Route('/topics/{slug}',name: 'topics')]
    public function topics(Request $request, Topics $topics, CommentService $commentService): Response
    {
        $commentService->form(
            $this->createForm(CommentFormType::class, $commentService->getComment()),
            $request
        );
        if ($commentService->dataForm($topics, $request)) {
            return $this->redirectToRoute('topics', ['slug' => $topics->getSlug()]);
        }
        $paginator = $commentService->getPagination();
        return $this->render('topics/index.html.twig', [
            'topics' => $topics,
            'comments' => $paginator['comments'],
            'previous' => $paginator['previous'],
            'next' => $paginator['next'],
            'comment_form' => $commentService->getForm()
        ]);
    }
}
