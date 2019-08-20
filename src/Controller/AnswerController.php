<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Repository\AnswerRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

        if ($answer->getStatus() == '1'){
            $answer->setStatus('2');
        }else{
            $answer->setStatus('1');
        }
        
        $om->flush();

        $this->addFlash('Danger', 'La réponse a bien été validée');

        return $this->redirectToRoute('question_show', ['id' => $questionId
        ]);
    }
    

     /**
     * @Route("/question/{id}", name="question_show", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function show(Security $security, Question $question, ValidatorInterface $validator, AnswerRepository $answerRepository, Request $request, ObjectManager $om)
    {
        if(!$question){
            throw $this->createNotFoundException('La question est introuvable');
        }
        $answers = $answerRepository->findByQuestion($question);

        $answer = new Answer();

        $form = $this->createForm(AnswerType::class, $answer);

        if ($request->isMethod('POST')) {
                
                $form->handleRequest($request);
                $errors = $validator->validate($answer);
                // dd($errors);
            
                if($form->isSubmitted() && $form->isValid()){
                    $user = $security->getUser();
                    $user->addAnswer($answer);

                    $question->addAnswer($answer);

                    $om->persist($answer);
                    $om->flush();

                    return $this->redirectToRoute('question_show', ["id" => $question->getId()]);
                }

                return $this->render('question/show.html.twig', [
                    'question' => $question,
                    'answers' => $answers,
                    'form' => $form->createView()
                ]);  

                
        }else{
               return $this->render('question/show.html.twig', [
                    'question' => $question,
                    'answers' => $answers,
                    'form' => $form->createView()
                ]);  
        }      
    }  
}
