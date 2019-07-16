<?php

namespace App\Controller\Backend;

use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    /**
     * @Route("/backend/users", name="backend_user_list")
     */
    public function list(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();
        
        return $this->render('backend/user/list.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/backend/user/role", name="backend_user_role", methods={"POST"})
     */
}
