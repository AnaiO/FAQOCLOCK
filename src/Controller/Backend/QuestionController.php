<?php

namespace App\Controller\Backend;

use App\Entity\Question;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionController extends AbstractController
{
    /**
     * @Route("/Backend/question/{id}/toggle", name="backend_question")
     */
    public function toggle(Question $question, ObjectManager $om)
    {
        if (!$question){
            return $this->createNotFoundException("La question n'existe pas");
        }
        $question->setStatus(0);

        $om->persist($question);
        $om->flush();

        $this->addFlash(
            'notice',
            'Vos modifications ont été prises en compte'
        );
        
        return $this->render('backend/question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }
}
