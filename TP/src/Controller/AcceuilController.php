<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;

class AcceuilController extends AbstractController
{
    #[Route('/acceuil', name: 'Acceuil')]
    public function index(RequestStack $requestStack): Response
    {   
        $session = $requestStack->getSession();
        $username=$session->get('username');
        $password = $session->get("password");
        $tel = $session->get("Tel");
        return $this->render('acceuil/index.html.twig', [
            'controller_name' => 'AcceuilController',
            "username"=>$username
        ]);
    }
}
