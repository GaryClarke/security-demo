<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    #[Route('/homepage', name: 'app_homepage')]
    public function index(): Response
    {
        return $this->render('app/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }


    #[Route('/not-the-homepage', name: 'alternate_page')]
    public function alternatePage(): Response
    {
        return $this->render('app/alternate-page.html.twig', []);
    }


    #[Route('/')]
    public function home(): Response
    {
        return $this->redirectToRoute('app_login');
    }
}