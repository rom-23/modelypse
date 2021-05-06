<?php

namespace App\Controller;

use App\Repository\ModelRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @param ModelRepository $repository
     * @return Response
     */
    public function home( ModelRepository $repository ): Response
    {
        $models = $repository -> findAllModelkit();
        $dModels = $repository -> findModelkitPng('3d');

        return $this -> render( 'pages/Home.html.twig', [
            'models'     => $models,
            'dModels'     => $dModels,
            'current_menu' => 'models'
        ] );
    }

}
