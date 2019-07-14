<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnswerController extends AbstractController
{
   /**
    * @Route("/user/question/answer/{id}/validate", name="answer_validate", methods={"GET", "POST"})
    */
    public function validate(Answer $answer, ObjectManager $om)
    {

        if (!$answer){
            $this->createNotFoundException("La réponse n'existe pas");
        }
        $question = $answer->getQuestion();
        $questionId = $question->getId();
        $answer->setStatus('2');

        $om->flush();

        return $this->redirectToRoute('question_show', ['id' => $questionId
        ]);
    }

    /**
    * @Route("/user/question/answer/{id}/novalidate", name="answer_novalidate", methods={"GET", "POST"})
    */
    public function noValidate(Answer $answer, ObjectManager $om)
    {

        if (!$answer){
            $this->createNotFoundException("La réponse n'existe pas");
        }
        $question = $answer->getQuestion();
        $questionId = $question->getId();
        $answer->setStatus('1');

        $om->flush();

        return $this->redirectToRoute('question_show', ['id' => $questionId
        ]);
    }

    
}
