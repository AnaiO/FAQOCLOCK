<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\SignUpType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{
    /**
     * @Route("/user/profile", name="profile_show", methods={"GET"})
     */
    public function show()
    {
        return $this->render('user/profile.html.twig');
    }

    /**
     * @Route("/user/profile/edit", name="profile_edit", methods={"GET","POST"})
     */
    public function edit(Security $security, UserPasswordEncoderInterface $passwordEncoder, Request $request)
    {
        $user = $security->getUser();
       
        $form = $this->createForm(SignUpType::class, $user);

        $oldPassword = $user->getPassword();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!is_null($user->getPassword())) {
                $encodedPassword = $passwordEncoder->encodePassword(
                    $user,
                    $user->getPassword()
               );
            } else {
                $encodedPassword = $oldPassword;
            }

            $user->setPassword($encodedPassword);

            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Vos modifications ont été sauvegardées');

            return $this->redirectToRoute('profile_show');
        }
        return $this->render('user/form.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    
}