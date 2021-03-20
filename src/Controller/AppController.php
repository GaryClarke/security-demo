<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AppController extends AbstractController
{
    #[Route('/homepage', name: 'app_homepage')]
    public function index()
    {
        return $this->render('app/index.html.twig', [
            'user' => $this->getUser()
        ]);
    }
}