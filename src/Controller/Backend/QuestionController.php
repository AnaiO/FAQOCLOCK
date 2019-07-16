<?php

namespace App\Controller\Backend;

use App\Entity\Question;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionController extends AbstractController
{
    /**
     * @Route("/Backend/question/{id}/toggle", name="backend_question_toggle", methods={"GET", "POST"})
     */
    public function toggle(Question $question, ObjectManager $om)
    {
        if (!$question){
            return $this->createNotFoundException("La question n'existe pas");
        }

        if ($question->getStatus() == '1'){
            $question->setStatus('0');
        }else{
            $question->setStatus('1');
        }
        
        $om->flush();

        $this->addFlash(
            'success',
            'Vos modifications ont été prises en compte'
        );
        
        return $this->redirectToRoute('question_list');
    }
}
