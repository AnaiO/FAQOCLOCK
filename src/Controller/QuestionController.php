<?php

namespace App\Controller;

use App\Repository\TagRepository;
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
}
