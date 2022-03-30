<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\VoitureRepository;
use App\Repository\PersonneRepository;
use App\Repository\VenteRepository;



class DashbordsController extends AbstractController
{
    #[Route('/dashboards', name: 'app_dashbords')]
    public function index(VenteRepository $vente,VoitureRepository $voiture,PersonneRepository $personne,RequestStack $requestStack): Response
    {   
        $user = $this->getUser();
        foreach($user->getRoles() as $role){
            if($role == "ROLE_USER")
            {
                return $this->render("Acceuil/index.html.twig");
            }
        }
        
        $nombrevoiture = 0;
        foreach($voiture->findAll() as $i){
            $nombrevoiture++;
        }
        $nombrepersonne = 0;
        foreach($personne->findAll() as $j){
            $nombrepersonne++;
        }
        $nombrevente = 0;
        foreach($vente->findAll() as $a)
            {
                $nombrevente++;
            }

        $session = $requestStack->getSession();
        $user = $this->getUser();
        $username=$user->getNomUtilisateur();
        $password = $session->get("password");
        $tel = $session->get("Tel");
        return $this->render('dashbords/TableauDeBords.html.twig', [
            'controller_name' => 'DashbordsController',
            "nombrevoiture" => $nombrevoiture,
            "nombrepersonne" =>$nombrepersonne,
            "nombrevente" =>$nombrevente,
            "username" =>$username,
            "password" =>$password,
            "tel" =>$tel
        ]);
    }
}
