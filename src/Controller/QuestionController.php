<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\TagRepository;
use App\Repository\QuestionRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\AnswerRepository;

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
     * @Route("/question/{id}", name="question_show", methods={"GET"})
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
}
