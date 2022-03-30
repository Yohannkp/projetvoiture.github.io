<?php
namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ClientRepository;
use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class LoginController extends AbstractController
{
    #[Route('/', name: 'login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
      {
         // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

         // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'error'=>$error,
            "last_username"=>$lastUsername,
        ]);
    }

    #[Route('/Inscription', name: 'Inscription2')]
    public function AjouterAuthUser(Request $request, ClientRepository $UserRepository,RequestStack $requestStack,UserPasswordHasherInterface $passwordhash): Response
    {
        $User=new Client();
        $form = $this->createForm(ClientType::class, $User);
        $form->handleRequest($request);
        $session=$requestStack->getSession();
        $Users=$UserRepository->findAll();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $User->setStatut(true);
            $hashdePassword=$passwordhash->hashPassword($User,$User->getpassword());
            $User->setpassword($hashdePassword);
            $UserRepository->add($User);
            return $this->redirectToRoute('login');
        }

        return $this->renderForm('login/AjouterUtilisateur.html.twig', [
            'User' => $User,
            'form' => $form,
            'User' => $UserRepository->findAll(),
            'Auth'=>$session
        ]);
    }
}