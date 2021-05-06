<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LandingController extends AbstractController
{

    /**
     * @Route("/", name="landing")
     * @return Response
     */
    public function home(): Response
    {
        return $this->redirectToRoute('home', [], 301);
    }

}
