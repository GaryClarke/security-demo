<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_BOOKKEEPER')]
class AccountsController extends AbstractController
{

    #[Route('/accounts/overview', name: 'accounts_overview')]
    public function index()
    {
        return $this->render('accounts/index.html.twig');
    }
}