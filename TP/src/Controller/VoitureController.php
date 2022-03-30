<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\VoitureRepository;
use App\Entity\Voiture;
use App\Form\VoitureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\EtatRepository;

#[Route('/')]
class VoitureController extends AbstractController
{

    #[Route('/voiture', name: 'voiture_index')]
    public function index(VoitureRepository $voiture,RequestStack $requestStack): Response
    {
        $user = $this->getUser();
        $username=$user->getNomUtilisateur();
        $session = $requestStack->getSession();
        $password = $session->get("password");
        $tel = $session->get("Tel");

        $nombre = $voiture->Nombrevoiture($voiture);
        
        return $this->render('voiture/index.html.twig', [
            'controller_name' => 'VoitureController',
            'voitures' => $voiture->findAll(),
            'erreur' => "Recherche d'une voiture",
            "username" => $username,
            "password" => $password,
            "tel" => $nombre,
        ]);
    }
    
    #[Route('/newVoiture', name: 'Ajout_voiture')]
    public function new(EtatRepository $Etat,Request $request, EntityManagerInterface $entityManager,RequestStack $requestStack):Response
    {
        $voiture = new Voiture();
        $form= $this->createForm(VoitureType::class,$voiture);
        $form->handleRequest($request);
        $session = $requestStack->getSession();
        $user = $this->getUser();
        $username=$user->getNomUtilisateur();
        $password = $session->get("password");
        $tel = $session->get("Tel");
        if($form->isSubmitted() && $form->isValid()){
            
            $voiture->setcreerLe(new \DateTime('now'));
            $voiture->setcreerPar($username);
            $voiture->setStatut(true);
            $voiture->setEtat("Disponible");
            $entityManager->persist($voiture);
            $entityManager->flush();
            return $this->redirectToRoute("voiture_index");
        }
        
      
        return $this->render('voiture/new.html.twig',[
            'form' => $form->createView(),
            'erreur' => "Recherche d'une voiture",
            "username" => $username,
            "password" => $password,
            "tel" => $tel,
        ]);
    }
    #[Route('/{id}/edit', name: "voiture_edit")]
    
    public function edit(Voiture $voiture,Request $request, EntityManagerInterface $entityManager,RequestStack $requestStack){
        
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
       
        $session = $requestStack->getSession();
        $user = $this->getUser();
        $username=$user->getNomUtilisateur();
        $password = $session->get("password");
        $tel = $session->get("Tel");

        if ($form->isSubmitted() && $form->isValid()) {
            $voiture->setModifierLe(new \DateTime('now'));
            $voiture->setModifierPar($username);
            
            $entityManager->flush();

            return $this->redirectToRoute('voiture_index');
        }
        
        return $this->render('voiture/edit.html.twig', [
                'voiture' => $voiture,
                'form' => $form->createView(),
                'erreur' =>"Recherche d'une voiture",
                "username" => $username,
                "password" => $password,
                "tel" => $tel,
            ]);
        
        

    }
    #[Route('/{id}', name: 'voiture_show', methods: ['GET'])]
    public function show(Voiture $voiture,RequestStack $requestStack)
    {
        $session = $requestStack->getSession();
        $user = $this->getUser();
        $username=$user->getNomUtilisateur();
        $password = $session->get("password");
        $tel = $session->get("Tel");
            return $this->render('voiture/show.html.twig', [
                'voiture' => $voiture,
                'erreur' =>"Recherche d'une voiture",
                "username" => $username,
                "password" => $password,
                "tel" => $tel,
            ]);
        
       
        
    }

    #[Route('/{id}/suppr', name: 'voiture_delete', methods: ['GET'])]
    public function supprimer(Voiture $voiture,EntityManagerInterface $entityManager)
    {
        $entityManager->remove($voiture);
        $entityManager->flush();
        return $this->redirectToRoute('voiture_index');
    }
    #[Route('/recherche', name: 'verificationVoiture', methods: ['GET', 'POST'])]
    public function showMatricule(VoitureRepository $voitureRepository,ClientRepository $clientRepository,RequestStack $requestStack): Response
    {
    
        if (isset($_POST['search'])){
            if (empty($_POST['search']))
            {
                $session = $requestStack->getSession();
                $user = $this->getUser();
                $username=$user->getNomUtilisateur();
                $password = $session->get("password");
                $tel = $session->get("Tel");
                return $this->render('voiture/index.html.twig', [
                    'voitures' => $voitureRepository->findAll(),
                    'erreur' =>"Entrez quelque chose s'il vous plaît",
                    "username" => $username,
                "password" => $password,
                "tel" => $tel,
                ]);
            }else{
            
                foreach ($voitureRepository->findAll() as $i){
                    if($i->getNumSerie() == $_POST['search'] || $i->getNumeroIdentifiant() == $_POST['search']){
                        $session = $requestStack->getSession();
                        $user = $this->getUser();
                        $username=$user->getNomUtilisateur();
                        $password = $session->get("password");
                        $tel = $session->get("Tel");
                        return $this->render('voiture/shows.html.twig', [
                            'voitures' => $voitureRepository->findAll(),
                            'matricule' => $_POST['search'],
                            'erreur' =>"Recherche",
                            "username" => $username,
                "password" => $password,
                "tel" => $tel,
                        ]);
                    }
                    if($i->getModel() == $_POST['search']){
                        $session = $requestStack->getSession();
                        $user = $this->getUser();
                        $username=$user->getNomUtilisateur();
        $password = $session->get("password");
        $tel = $session->get("Tel");
                        return $this->render('voiture/indexs.html.twig', [
                            'voitures' => $voitureRepository->findAll(),
                            'matricule' => $_POST['search'],
                            'erreur' =>"Recherche",
                            "username" => $username,
                            "password" => $password,
                            "tel" => $tel,
                        ]);
                    }
                }
            
                $session = $requestStack->getSession();
                $user = $this->getUser();
        $username=$user->getNomUtilisateur();
                $password = $session->get("password");
                $tel = $session->get("Tel");
                return $this->render('voiture/index.html.twig', [
                    'voitures' => $voitureRepository->findAll(),
                    'erreur' =>"Aucun element correspondant a votre recherche",
                    "username" => $username,
                "password" => $password,
                "tel" => $tel,
                ]);
                
            }
        
    
    return $this->redirectToRoute('voiture_index');
}

    }
}
