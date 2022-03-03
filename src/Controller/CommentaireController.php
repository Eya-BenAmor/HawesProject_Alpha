<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commentaire;
use App\Entity\Publication;
use App\Entity\User;
use App\Repository\CommentaireRepository ;
use App\Form\CommentaireType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Notifications\NouveauPublicationNotification;
use App\Repository\PublicationRepository ;

class CommentaireController extends AbstractController
{
    /**
     * @Route("/commentaire", name="commentaire")
     */
    public function index(): Response
    {
        return $this->render('commentaire/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }

  /**
     * @Route("/listcom/{id}", name="listcom")
     */
    public function listcom($id): Response
    {
        $rep=$this->getDoctrine()->getRepository(commentaire::class);
        $repPublication=$this->getDoctrine()->getRepository(publication::class);
        $commentaire =$rep->ListCommentaireByPublication($id);
        $publication = $repPublication->ListPublicationById($id);
       
        
           $value = $publication[0]->getViews();
            $value = $value + 1 ;
            $publication[0]->setViews($value);
            $em=$this->getDoctrine()->getManager();
            $em->flush();

        return $this->render('commentaire/listc.html.twig', [
            'commentaire' => $commentaire,
            'publication' =>$publication[0]

        ]);
    }

/**
     * @Route("/addcom/{id}", name="addcom")
     */
    public function add(Request $request,$id): Response
    {
        $commentaire=new commentaire() ; // nouvelle instance 
        $form=$this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
         $rep=$this->getDoctrine()->getRepository(Publication::class);
      
      $publication=$rep->find($id);
      $rep2=$this->getDoctrine()->getRepository(User::class);
        $user=$rep2->find('1');
if ($form->isSubmitted() && $form->isValid())
{
    
$commentaire=$form->getData();
$commentaire->setUser($user);
$commentaire->setPublication($publication);
$em=$this->getDoctrine()->getManager();
$em->persist($commentaire);
$em->flush();
return $this->redirectToRoute('listpubfront');
}


        return $this->render('commentaire/addc.html.twig', [
            'formC' => $form->createView(),
        ]);
        

    }



    
     /**
     * @Route("/updatecom/{id}", name="updatecom")
     */
    public function update(Request $request, $id): Response
    { $rep=$this->getDoctrine()->getRepository(commentaire::class);
        $commentaire=$rep->find($id); // nouvelle instance 
        $form=$this->createForm(CommentaireType::class,$commentaire);
        $form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid())
{
//$commentaire=$form->getData();
$em=$this->getDoctrine()->getManager();
$em->flush();
return $this->redirectToRoute('listpubfront');
}


        return $this->render('commentaire/updatec.html.twig', [
            'formC' => $form->createView(),
        ]);
        

    }


     /**
     * @Route("/deletecom/{id}", name="deletecom")
     */
    public function deletepub($id): Response
    { $rep=$this->getDoctrine()->getRepository(commentaire::class);
      $em=$this->getDoctrine()->getManager();
      $commentaire=$rep->find($id);
      $em->remove($commentaire);
      $em->flush(); 

        return $this->redirectToRoute('listpubfront');
       
    }








}
