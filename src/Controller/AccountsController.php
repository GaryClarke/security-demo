<?php

namespace App\Controller;

use App\Entity\Account;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountsController extends AbstractController
{
    #[Route('/accounts/overview', name: 'accounts_overview')]
    #[IsGranted('ROLE_BOOKKEEPER')]
    public function index()
    {
        return $this->render('accounts/index.html.twig');
    }


    #[Route('/accounts/{id}', methods: ['GET'])]
    #[IsGranted('SHOW', subject: 'account')]
    public function show(Account $account)
    {
        return $this->render('accounts/show.html.twig', [
            'account' => $account
        ]);
    }


    #[Route('/accounts/{id}/delete', name: 'delete_account', methods: ['GET'])]
    #[IsGranted('DELETE', subject: 'account')]
    public function delete(Account $account)
    {
        return new Response('Deleting account ' . $account->getId());
    }













}