<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Topics;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
         $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(TopicsCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('ForumSymfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Вернуться на главную страницу','fas fa-home', 'homepage');
        yield MenuItem::linkToCrud('Темы','fas fa-map-marker-alt', Topics::class);
        yield MenuItem::linkToCrud('Комментарии','fas fa-comments', Comment::class);
    }
}
