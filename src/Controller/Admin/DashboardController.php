<?php

namespace App\Controller\Admin;

use App\Entity\Choice;
use App\Entity\Client;
use App\Entity\Data;
use App\Entity\DataClient;
use App\Entity\Plat;
use App\Entity\Question;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Persil Romarin Api');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Questions', 'fas fa-question', Question::class);
        yield MenuItem::linkToCrud('Choix questions', 'fas fa-code-branch', Choice::class);
        yield MenuItem::linkToCrud('Data', 'fas fa-database', Data::class);
        yield MenuItem::linkToCrud('Réponses utilisateurs', 'fas fa-user-edit', Client::class);
        yield MenuItem::linkToCrud('Plats', 'fas fa-seedling', Plat::class);
    }
}
