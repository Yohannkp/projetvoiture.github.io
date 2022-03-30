<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Vente;
use App\Form\VenteType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\VenteRepository;
use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use App\Repository\EtatRepository;
use App\Entity\Etat;
use Symfony\Component\HttpFoundation\RequestStack;

#[Route("/vente")]
class VenteController extends AbstractController
{
    #[Route('/', name: 'app_vente')]
    public function index(VenteRepository $vente,RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $username=$session->get('username');
        $password = $session->get("password");
        $tel = $session->get("Tel");
        
        
        return $this->render('vente/index.html.twig', [
            'controller_name' => 'VenteController',
            'ventes' => $vente->findAll(),
            "username" => $username,
            "password" => $password,
            "tel" => $tel,]);
        

        
        
    }
    #[Route("/nouvelleVente", name:"newVente")]
    public function NewVente(Request $request, EntityManagerInterface $em,VoitureRepository $voiture, VenteRepository $vr,EtatRepository $et,RequestStack $requestStack){
        $vente = new Vente();
        $form = $this->createForm(VenteType::class,$vente);
        $form->handleRequest($request);
        $session = $requestStack->getSession();
        $username=$session->get('username');
        $password = $session->get("password");
        $tel = $session->get("Tel");

        if($form->isSubmitted() && $form->isValid()){
            $message = "Cette voiture n'est plus disponible";
            if($vente->getVoiture()->getEtat() == "Vendu"){
                return $this->render("vente/new.html.twig",['form'=>$form->createView(),"erreur"=>"Recherche","username" => $username,
                "password" => $password,
                "tel" => $tel,
                "Message"=>$message]);
            }else{
                //$vr->findByEtat($voiture,$vente,$em,$et);
                $vente->setCreerLe(new \DateTime('now'));
                $vente->setCreerPar($username);
                $vente->setStatut(true);
                $vente->getVoiture()->setEtat("Vendu");
                $em->persist($vente);
            
                $em->flush();
                return $this->redirectToRoute("app_vente");
            }

            
            
            //
            
        }
        
        return $this->render("vente/new.html.twig",['form'=>$form->createView(),"erreur"=>"Recherche","username" => $username,
        "password" => $password,
        "tel" => $tel,
        "Message"=>""]);
    }
    
    #[Route('/{id}/edit', name:"editVente")]
    public function editVoiture(Vente $vente,Request $request, EntityManagerInterface $em,RequestStack $requestStack)
    {
        $form = $this->createForm(VenteType::class,$vente);
        $form->handleRequest($request);
        $vente->getVoiture()->setEtat("Disponible");
        $em->flush();
        $session = $requestStack->getSession();
        $username=$session->get('username');
        $password = $session->get("password");
        $tel = $session->get("Tel");

        if($form->isSubmitted() && $form->isValid()){
            $vente->setModifierLe(new \DateTime('now'));
            $vente->setModifierPar($username);
            $vente->getVoiture()->setEtat("Vendu");
            $em->flush();
            return $this->redirectToRoute("app_vente");
        }
        return $this->render("vente/edit.html.twig",["form"=>$form->createView(),"username" => $username,
        "password" => $password,
        "tel" => $tel,]);
    }

    #[Route('/{id}/supp', name: "supprimer_vente")]
    public function annulerVente(Vente $vente,EntityManagerInterface $em,RequestStack $requestStack){
        $em->remove($vente);
        $em->flush();
        return $this->redirectToRoute("app_vente");
    }

    #[Route('/{id}/voire', name: "voire_vente")]
    public function voireVente(Vente $vente,RequestStack $requestStack)
    {   $session = $requestStack->getSession();
        $username=$session->get('username');
        $password = $session->get("password");
        $tel = $session->get("Tel");
        return $this->render('vente/voire.html.twig',['vente'=>$vente,"username" => $username,
        "password" => $password,
        "tel" => $tel,]);
    }

    #[Route("/RechercheVente", name: "recherchevente")]
    public function rechercheVente(VenteRepository $vente,RequestStack $requestStack)
    {
        if(isset($_POST['Debut']) || isset($_POST['Fin'])){
            $debut = $_POST['Debut'];
            $fin = $_POST['Fin'];
            $session = $requestStack->getSession();
        $username=$session->get('username');
        $password = $session->get("password");
        $tel = $session->get("Tel");
            
            return $this->render("vente/index.html.twig",['ventes'=>$vente->findByYear($debut,$fin),"username" => $username,
            "password" => $password,
            "tel" => $tel,]);
        
        
        }
        return $this->redirectToRoute("app_vente");
    }
}
