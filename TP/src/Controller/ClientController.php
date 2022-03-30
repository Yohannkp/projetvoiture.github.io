<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\RoleRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/client')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'app_client_index', methods: ['GET'])]
    public function index(ClientRepository $clientRepository,RequestStack $requestStack): Response

    {   $session = $requestStack->getSession();
        $username=$session->get('username');
        $password = $session->get("password");
        $tel = $session->get("Tel");
        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findAll(),
            "erreur" => "Recherche d'un client",
            "erreurs" =>"Recherche d'une voiture",
            "username" => $username,
            "password" => $password,
            "tel" => $tel,
        ]);

        
        
    }

    #[Route('/client/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request,UserPasswordHasherInterface $passwordhash, ClientRepository $clientRepository,RequestStack $requestStack,RoleRepository $role): Response
    {
        $session = $requestStack->getSession();
        $username=$session->get('username');
        $password = $session->get("password");
        $tel = $session->get("Tel");
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client->setcreerLe(new \DateTime('now'));
            $client->setcreerPar($username);
            $client->setStatut(true);
            $hashdePassword=$passwordhash->hashPassword($client,$client->getpassword());
            $client->setpassword($hashdePassword);
            $clientRepository->add($client);
            
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }
        
            return $this->renderForm('client/new.html.twig', [
                'client' => $client,
                'form' => $form,
                "username" => $username,
            "password" => $password,
            "tel" => $tel,
            ]);
        
       
    }

    #[Route('/client/{id}', name: 'app_client_show', methods: ['GET'])]
    public function show(Client $client,RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $username=$session->get('username');
        $password = $session->get("password");
        $tel = $session->get("Tel");
        return $this->render('client/show.html.twig', [
            'client' => $client,
            'erreur'=>"Recherche d'un client",
            "username" => $username,
            "password" => $password,
            "tel" => $tel,
        ]);
    }

    #[Route('/client/{id}/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, ClientRepository $clientRepository,RequestStack $requestStack): Response
    {   

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);
        $session = $requestStack->getSession();
        $username=$session->get('username');
        $password = $session->get("password");
        $tel = $session->get("Tel");
        $user = $this->getUser();


        if ($form->isSubmitted() && $form->isValid()) {
            $client->setModifierLe(new \DateTime('now'));
            $client->setModifierPar($user->getNomUtilisateur());
            $clientRepository->add($user->getNomUtilisateur());
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->renderForm('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
            "username" => $user->getNomUtilisateur(),
            "password" => $password,
            "tel" => $user->getRoles(),
        ]);
    }
    #[Route('AjouteAdmin', name:"ajout_admin")]

    public function FUNCTION(Request $request,UserPasswordHasherInterface $passwordhash, ClientRepository $clientRepository,RequestStack $requestStack,RoleRepository $role): Response
    {
        $session = $requestStack->getSession();
        $username=$session->get('username');
        $password = $session->get("password");
        $tel = $session->get("Tel");
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $client->setcreerLe(new \DateTime('now'));
            $client->setcreerPar($username);
            $client->setStatut(true);
            $client->setRoles(["ROLE_ADMIN"]);
            $hashdePassword=$passwordhash->hashPassword($client,$client->getpassword());
            $client->setpassword($hashdePassword);
            $clientRepository->add($client);
            
            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }
        
            return $this->renderForm('client/new.html.twig', [
                'client' => $client,
                'form' => $form,
                "username" => $username,
            "password" => $password,
            "tel" => $tel,
            ]);
        
       
    }
/*
    #[Route('/client/{id}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, Client $client, ClientRepository $clientRepository): Response
    {
        
        $clientRepository->remove($client);
        return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
    }
*/
    #[Route('/{id}/suppr', name: 'client_supp')]
    public function delete(Client $client, EntityManagerInterface $entityManager,RequestStack $requestStack)
    {   
        $entityManager->remove($client);
        $entityManager->flush();
        return $this->redirectToRoute('app_client_index');
        
    }
    #[Route('/recherche', name: 'verificationClient', methods: ['GET', 'POST'])]
    public function showMatricule(ClientRepository $clientRepository,RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $username=$session->get('username');
        $password = $session->get("password");
        $tel = $session->get("Tel");
                if(isset($_POST['search'])){
                    if(empty($_POST['search'])){
                        
                        return $this->render("client/index.html.twig",['erreur' => "Entrer quelque chose s'il vous plait",'clients'=>$clientRepository->findAll(),"username" => $username,
                        "password" => $password,
                        "tel" => $tel,]);
                    }
                    $recherche = $_POST['search'];
                    $recherche = $clientRepository->findByName($recherche);
                    return $this->render("client/index.html.twig",['erreur' => "Recherche d'un client",'clients'=>$recherche,"username" => $username,
                        "password" => $password,
                        "tel" => $tel,]);
                    
            }
                
                
            $session = $requestStack->getSession();
            $username=$session->get('username');
            $password = $session->get("password");
            $tel = $session->get("Tel");
                return $this->render('client/index.html.twig', [
                    'voitures' => $clientRepository->findAll(),
                    'erreur' =>"Aucun element correspondant a votre recherche",
                    'erreurs' => "Rechercher une voiture",
                    'clients'=>$clientRepository->findAll(),
                    "username" => $username,
            "password" => $password,
            "tel" => $tel,
                        ]);
                
            }

        #[Route('/rechercheAge', name: 'verificationAge', methods: ['GET', 'POST'])]
        public function verificationAge(ClientRepository $client,RequestStack $requestStack)
        {   if(isset($_POST['Debut']) || isset($_POST['Fin'])){
            $debut = $_POST['Debut'];
            $fin = $_POST['Fin'];
            $session = $requestStack->getSession();
        $username=$session->get('username');
        $password = $session->get("password");
        $tel = $session->get("Tel");
            
            return $this->render('client/index.html.twig',['clients'=>$client->findByYear($debut,$fin),"erreur" =>"Rechercher un client","username" => $username,
            "password" => $password,
            "tel" => $tel,]);
        }

        return $this->redirectToRoute("app_client_index");
    }
}


    


