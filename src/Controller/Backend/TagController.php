<?php

namespace App\Controller\Backend;

use App\Entity\Tag;
use App\Form\TagType;
use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
    /**
     * @Route("/backend/tag/list", name="backend_tag_list", methods={"GET"})
     */
    public function list(TagRepository $tagRepository)
    {
        $tags = $tagRepository->findAll();
        return $this->render('backend/tag/list.html.twig', [
            'tags' => $tags
        ]);
    }

    /**
     * @Route("/backend/tag/new", name="backend_tag_new", methods={"GET", "POST"})
     * @Route("/backend/tag/{id}/edit", name="backend_tag_edit", methods={"GET", "POST"})
     */
    public function form(Tag $tag=null, Request $request, ObjectManager $om)
    {
        if (!$tag){
            $tag = new Tag;
        }
     
        $form = $this->createForm(TagType::class, $tag);

        if ($request->isMethod('POST')) {
                
                $form->handleRequest($request);
            
            
                if($form->isSubmitted() && $form->isValid()){
                    if(!$tag->getId()){
                        $tag->setCreatedAt(new \DateTime());
                    }

                   $tag->setUpdatedAt(new \DateTime());
                    $om->persist($tag);
                    $om->flush();
                }

                return $this->redirectToRoute('backend_tag_list');
        }else{
                return $this->render('backend/tag/form.html.twig', [
                'form' => $form->createView()
            ]);
        }    
    }
    

    /**
     * @Route("/backend/tag/{id}/delete", name="backend_tag_delete", methods={"GET", "POST"})
     */
    public function delete(Tag $tag, ObjectManager $om)
    {
        if (!$tag) {
            throw $this->createNotFoundException(
                'Oops, le tag n\'existe pas ! '
            );
        }

          $om->remove($tag);
          $om->flush();

          return $this->redirectToRoute('backend_tag_list');
    }
}
