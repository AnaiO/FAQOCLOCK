<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Question;
use App\Form\QuestionType;
use Doctrine\ORM\EntityManager;
use App\Repository\TagRepository;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QuestionController extends AbstractController
{
    /**
     * @Route("/", name="question_list", methods={"GET"})
     */
    public function list(QuestionRepository $questionRepository, TagRepository $tagRepository)
    {
        $questions = $questionRepository->lastRelease();
        $tags = $tagRepository->findAll();

        return $this->render('question/list.html.twig', [
            'questions' => $questions,
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/question/{id}", name="question_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Question $question, AnswerRepository $answerRepository)
    {
        if(!$question){
            throw $this->createNotFoundException('La question est introuvable');
        }
        $answers = $answerRepository->findByQuestion($question);

        return $this->render('question/show.html.twig', [
            'question' => $question,
            'answers' => $answers
        ]);
    }

    /**
     * @Route("/question/tag/{name}", name="questions_tag", methods={"GET"})
     */
    public function listByTag(Tag $tag)
    {
       return $this->render("question/tag.html.twig", [
           'tag' => $tag
       ]);
    }

     /**
      * @Route("/user/question/ask", name="question_ask", methods={"POST", "GET"})
      * 
      */
    public function form(Question $question=null, ObjectManager $om, Request $request)
      { 
        $question = new Question;
        
        $form = $this->createForm(QuestionType::class, $question);

        if ($request->isMethod('POST')) {
                
                $form->handleRequest($request);
            
            
                if($form->isSubmitted() && $form->isValid()){
                    if(!$question->getId()){
                        $question->setCreatedAt(new \DateTime());
                    }

                   $question->setUpdatedAt(new \DateTime());
                    $em->persist($question);
                    $em->flush();
                }

                return $this->redirectToRoute('question_list');
        }else{
                return $this->render('question/form.html.twig', [
                'form' => $form->createView()
            ]);
        }    

      }

      /**
       * @Route("/question/{id}/delete", name="question_delete", methods={"POST"})
       */
    // public function delete(Question $question, EntityManager $em)
    //   {
    //     if (!$question) {
    //         throw $this->createNotFoundException(
    //             'Oops, la question n\'existe pas'
    //         );
    //     }

    //       $em->remove($question);
    //       $em->flush();

    //       return $this->redirectToRoute('question_list');
    //   }
}
