<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Topics;
use App\Form\CommentFormType;
use App\Repository\TopicsRepository;
use App\Service\ProcessesComment;
use App\Service\FormComment;
use App\Service\PaginationComment;
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
    public function topics(Request $request, Topics $topics, ProcessesComment $processesComment, PaginationComment $paginationComment, FormComment $formComment): Response
    {
        $comment = new Comment();
        $formComment->createForm($this->createForm(CommentFormType::class, $comment), $request);
        if ($formComment->checkForm()) {
            $processesComment->processes($comment, $topics);
            return $this->redirectToRoute('topics', ['slug' => $topics->getSlug()]);
        }
        $paginationComment->create($request, $topics);
        $paginator = $paginationComment->getPagination();

        return $this->render('topics/index.html.twig', [
            'topics' => $topics,
            'comments' => $paginator['comments'],
            'previous' => $paginator['previous'],
            'next' => $paginator['next'],
            'comment_form' => $formComment->getFormView()
        ]);
    }
}
