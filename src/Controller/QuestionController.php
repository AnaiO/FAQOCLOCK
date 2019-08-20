<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Answer;
use App\Entity\Question;
use App\Form\AnswerType;
use App\Form\QuestionType;
use Doctrine\ORM\EntityManager;
use App\Repository\TagRepository;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
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
    public function form(Security $security, Question $question=null, ObjectManager $om, Request $request)
      { 
        $question = new Question;
        
        
        $form = $this->createForm(QuestionType::class, $question);

        if ($request->isMethod('POST')) {
               
                $form->handleRequest($request);

                if($form->isSubmitted() && $form->isValid()){
            
                    $user = $security->getUser();
                    $user->addQuestion($question);
                    
                    if(!$question->getId()){
                        $question->setCreatedAt(new \DateTime());
                    }

                   $question->setUpdatedAt(new \DateTime());
                   
                    $om->persist($question);
                    $om->flush();
                    
                    return $this->redirectToRoute('question_list');
                }

                return $this->render('question/form.html.twig', [
                    'form' => $form->createView(),
                    
                ]);
                
        }else{
                
                return $this->render('question/form.html.twig', [
                'form' => $form->createView(),
                
            ]);
        }    

    }

      /**
       * @Route("user/question/{id}/like/{route}", name="question_like", methods={"GET", "POST"})
       */
    public function addLike(Question $question, ObjectManager $om, Request $request, $route)
      {
        $likes = $question->getNbLikes();
        $likes += 1;
        $question->setNbLikes($likes);

        $om->flush();

        

        if ($route == 'homePage'){
           return $this->redirectToRoute("question_list"); 
        }else{
            return $this->redirectToRoute("questions_tag", ['name' => $route]);
        }
        
      }
}
