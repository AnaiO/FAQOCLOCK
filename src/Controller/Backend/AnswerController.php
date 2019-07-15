<?php

namespace App\Controller\Backend;

use App\Entity\Answer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnswerController extends AbstractController
{
    /**
     * @Route("/backend/question/answer/{id}/toggle", name="backend_answer_toggle", methods={"GET", "POST"})
     */
    public function toggle(Answer $answer, ObjectManager $om)
    {
        if (!$answer){
            return $this->createNotFoundException("La réponse n'existe pas");
        }

        if ($answer->getStatus() == '1' || $answer->getStatus() == '2'){
            $answer->setStatus('0');
        }else{
            $answer->setStatus('1');
        }
        
        $om->flush();

        $this->addFlash(
            'notice',
            'Vos modifications ont été prises en compte'
        );

        $question = $answer->getQuestion();
        $questionId = $question->getId();
        
        return $this->redirectToRoute('question_show', ['id' => $questionId]);
    }
}
