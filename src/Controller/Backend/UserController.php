<?php

namespace App\Controller\Backend;

use App\Entity\Role;
use App\Entity\User;
use App\Repository\RoleRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/backend/users", name="backend_users_list")
     */
    public function list(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        
        return $this->render('backend/user/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/backend/users/{id}/role", name="backend_users_role", methods={"GET", "POST"})
     */
    public function toggleRole(User $user, RoleRepository $roleRepository, ObjectManager $om, Request $request)
    {
        if (!$user){
            return $this->createNotFoundException('L\'utilisateur est inconnu');
        }

        $userCurrentRole = $user->getRole();
        $userCurrentRole->removeUser($user);

        $role = $roleRepository->findByNameRole('Moderator');

        
        $role->addUser($user);
dd($user);
        

        return $this->redirectToRoute('backend_users_list');
    }
}
