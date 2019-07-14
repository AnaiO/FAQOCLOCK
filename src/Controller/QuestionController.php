<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Entity\Question;
use App\Repository\TagRepository;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
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
     * @Route("/question/{id}", name="question_show", methods={"GET"}, requirements={"page"="\d+"})
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
      * @Route("/question/ask", name="question_ask", methods={"POST"})
      * @Route("/question/{id}/edit", name="question_edit", methods={"POST"})
      */
    public function form()
      {
          //formulaire de création et édition d'une question
      }

      /**
       * @Route("/question/{id}/delete", name="question_delete", methods={"POST"})
       */
    public function delete(Question $question, EntityManager $em)
      {
        if (!$question) {
            throw $this->createNotFoundException(
                'Oops, la question n\'existe pas'
            );
        }

          $em->remove($question);
          $em->flush();

          return $this->redirectToRoute('question_list');
      }
}
