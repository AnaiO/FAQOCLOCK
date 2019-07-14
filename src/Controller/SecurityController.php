<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignUpType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="logout", methods={"GET"})
     */
    public function logout()
    {
        
        
    }

     /**
     * @Route("/signup", name="signup")
     */
    public function signUp(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User;
        $form = $this->createForm(SignUpType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encodedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encodedPassword);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }
}
