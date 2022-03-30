<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PersonneRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use App\Repository\RoleRepository;

class AuthentificationController extends AbstractController
{
    #[Route('/adminpath', name: 'app_authentification')]
    public function index(): Response
    {
        return $this->render('Authentification/Connexion.html.twig', [
            'controller_name' => 'AuthentificationController',
            'Message' => ''
        ]);
    }
/*
    #[Route('/login', name: 'app_login')]
    public function auth(AuthenticationUtils $authenticationUtils, VoitureRepository $voiture): Response
    {
            // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

         // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('Authentification/Connexion.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
            'voiture' => $voiture->findAll(),
        ]);
    }
   */

    #[Route('/Connexion', name: 'app_login',methods: ['GET','POST'])]
    public function login(Request $request,PersonneRepository $personneRepository,RequestStack $requestStack,RoleRepository $role): Response
    {
        
        if(isset($_GET['username']) && isset($_GET['password'])){

            $username = $request->request->get('username');
            $password = $request->request->get('password');
            
            //$personne = $personneRepository->findBy(array('NomUtilisateur' => $username,'MotDePass'=>$password));
          
            $personneRepository = $personneRepository->findAll();
            foreach($personneRepository as $element) {
                if($element->getNomUtilisateur() == $_GET['username'] && $element->getMotDePass() == $_GET['password'])
                {       
                        if($element->getRole()->getRoleUser() == $role->find(1)->getRoleuser()){
                            $session = $requestStack->getSession();
                            $session->set("username",$_GET['username']);
                            $session->set("password",$_GET['password']);
                            $session->set("Tel",$element->getTelephone());
                            return $this->redirectToRoute("app_dashbords");
                        }else{
                            $session = $requestStack->getSession();
                            $session->set("username",$username);
                            $session->set("password",$password);
                            $session->set("Tel",$element->getTelephone());
                            return $this->redirectToRoute("Acceuil");
                        }
                        
                    }
                
                }$message = "Address ou mot de passe invalide";
                return $this->render("Authentification/Connexion.html.twig",['Message'=>$message]);
            }

        print_r($_POST);
        return $this->redirectToRoute("voiture_index");
    }

    #[Route('/Deconnexion', name:"Deconnexion")]
    public function deconnexionAction(RequestStack $requestStack){
        $session = $requestStack->getSession();
        $session->set("username",null);
        $session->set("password",null);
        $session->set("Tel",null);
        return $this->redirectToRoute("/");
    }
}
