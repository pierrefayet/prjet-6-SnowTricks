<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CommentController extends AbstractController
{
    #[Route('/add_comment', name: 'add_comment')]
    public function AddComment(Request $request, EntityManagerInterface $entityManager,Trick $trick):Response
    {
        $comment = new Comment;
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('single_trick', ['id' => $trick->getId()]);
        }

        return $this->render('singleTrick.html.twig', [
            'comment' => $form->createView()
        ]);
    }

    #[Route('/delete_comment/{id}', name: 'delete_comment')]
    public function deleteTrick(Comment $comment, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($comment);
        $entityManager->flush();

        return $this->redirectToRoute('single_trick');
    }
}
