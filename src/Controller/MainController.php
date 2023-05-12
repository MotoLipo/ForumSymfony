<?php

namespace App\Controller;


use App\Entity\Comment;
use App\Entity\Topics;
use App\Form\CommentFormType;
use App\Repository\CommentRepository;
use App\Repository\TopicsRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    public function topics(Request $request,CommentRepository $commentRepository, Topics $topics, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $comment->setTopics($topics);

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('topics', ['slug' => $topics->getSlug()]);
        }

        $offset = max(0, $request->query->getInt('offset',0));
        $paginator = $commentRepository->getCommentPaginator($topics,$offset);

        return $this->render('topics/index.html.twig', [
            'topics' => $topics,
            'comments' => $paginator,
            'previous' => $offset - CommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($paginator), $offset + CommentRepository::PAGINATOR_PER_PAGE),
            'comment_form' => $form->createView()
        ]);
    }
}
