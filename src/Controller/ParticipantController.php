<?php

namespace App\Controller;
use App\Entity\Participant ;

use App\Entity\Randonnee ;
use App\Entity\Client ;
use App\Repository\RandonneeRepository;
use App\Form\ParticipantType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class ParticipantController extends AbstractController
{
    /**
     * @Route("/participant", name="participant")
     */
    public function index(): Response
    {
        return $this->render('participant/participer.html.twig', [
            'controller_name' => 'ParticipantController',
        ]);
    }


     /**
     * @Route("/ajouterParticipant/{id}", name="ajouterParticipant")
     */
    public function ajouterP(Request $request,$id): Response
    {
        $participant=new Participant() ; // nouvelle instance 
        $form=$this->createForm(ParticipantType::class,$participant);
        $form->handleRequest($request);
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);
      
      $randonnee=$rep->find($id);
      $rep2=$this->getDoctrine()->getRepository(Client::class);
     
      $client=$rep2->find('1');
if ($form->isSubmitted() && $form->isValid()) 
{
$participant=$form->getData();
$participant->setRandonnee($randonnee);
$participant->setClient($client);
$em=$this->getDoctrine()->getManager();
$em->persist($participant);
$em->flush();
return $this->redirectToRoute('indexFront');
}


        return $this->render('participant/participer.html.twig', [
            'formA' => $form->createView(),
        ]);
        

    }



     /**
     * @Route("/listerParticipant", name="listerParticipant")
     */
    public function listerP(): Response
    { 
        $rep=$this->getDoctrine()->getRepository(Participant::class);
        
        $participant =$rep-> findAll();
      
        return $this->render('participant/listerParticipant.html.twig', [
            'parti' => $participant,
           
        ]);
    }



    /**
     * @Route("/supprimerParticipant/{id}", name="supprimerParticipant")
     */
    
    public function supprimerP($id): Response
    { $rep=$this->getDoctrine()->getRepository(Participant::class);
      $em=$this->getDoctrine()->getManager();
      $participant=$rep->find($id);
      $em->remove($participant);
      $em->flush(); 

        return $this->redirectToRoute('listerParticipant');
       
    }


/**
     * @Route("/modifierParticipant/{id}", name="modifierParticipant")
     */
    public function modifierP(Request $request, $id): Response
    { $rep=$this->getDoctrine()->getRepository(Participant::class);
        $participant=$rep->find($id); // nouvelle instance 
        $form=$this->createForm(ParticipantType::class,$participant);
        $form->handleRequest($request);
        
if ($form->isSubmitted()&& $form->isValid()) 
{

$em=$this->getDoctrine()->getManager();
$em->flush();
return $this->redirectToRoute('listerParticipant');
}


        return $this->render('participant/modifierParticipant.html.twig', [
            'formA' => $form->createView(),
        ]);
        

    }


}
