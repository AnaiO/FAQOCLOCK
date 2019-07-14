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
     * @Route("/user/question/{id}/answer", name="answer", requirements={"id"="\d+"}, methods={"GET", "POST"})
     */
    public function answer(Question $question, ObjectManager $om, Request $request)
    {
        //formulaire à inclure dans la page show tout simplement
        $answer = new Answer();

        $form = $this->createForm(AnswerType::class, $answer);

        if ($request->isMethod('POST')) {
                
                $form->handleRequest($request);
            
            
                if($form->isSubmitted() && $form->isValid()){
                    if(!$answer->getId()){
                        $answer->setCreatedAt(new \DateTime());
                    }

                //    $question->setUpdatedAt(new \DateTime());
                    $om->persist($answer);
                    $om->flush();
                }

                return $this->redirectToRoute('question_show', ["id" => $question->getId()]);
        }else{
                return $this->render('answer/form.html.twig', [
                'form' => $form->createView()
            ]);
        }    

    }

    
}
