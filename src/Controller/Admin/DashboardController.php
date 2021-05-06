<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Model;
use App\Entity\Option;
use App\Entity\User;
use App\Repository\ModelRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/*
 * @IsGranted("ROLE_ADMIN")
 */
class DashboardController extends AbstractDashboardController
{
    protected $modelRepository;

    /**
     * @param ModelRepository $modelRepository
     */
    public function __construct(ModelRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $models = $this->modelRepository->findAllModelkit();
        return $this->render('bundle/easyadmin/welcome.html.twig', [
            'agencies'     => $models,
            'current_menu' => 'agencies'
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
                        ->setTitle('');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoDashboard('Home', 'fa fa-home'),
            MenuItem::linkToCrud('Model', 'fas fa-list', Model::class),
            MenuItem::linkToCrud('Category', 'fas fa-list', Category::class),
            MenuItem::linkToCrud('Option', 'fas fa-list', Option::class),
            MenuItem::linkToCrud('Image', 'fas fa-list', Image::class),
            MenuItem::section('Users'),
            MenuItem::linkToCrud('User', 'fas fa-list', User::class),
        ];
    }
}
