<?php

namespace App\Controller;


use App\Entity\Randonnee ;
use App\Entity\User ;
use App\Entity\Participant;
use App\Repository\ParticipantRepository;
use App\Form\ParticipantType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Builder\BuilderRegistryInterface;
use Endroid\QrCode\Builder\BuilderInterface;
use Endroid\QrCodeBundle\Response\QrCodeResponse;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
class ParticipantController extends AbstractController
{


    public function __construct(BuilderInterface $customQrCodeBuilder)
    {
        $result = $customQrCodeBuilder
            ->size(400)
            ->margin(20)
            ->build();
    }



/**
     * @Route("/qrcode/{id}",name="qrcode")
     */
    public function qrcode(BuilderInterface $customQrCodeBuilder , $id ){
    $rep=$this->getDoctrine()->getRepository(Participant::class);
     $reservation = $rep->find($id);
        return new QrCodeResponse($customQrCodeBuilder->size(400)
        ->margin(20)
        ->data('Un participant à : '.$reservation->getRandonnee()->getNomRando())
        ->build());
    }

/**
     * @Route("/histo", name="histo")
     */
    public function histo(Request $request,PaginatorInterface $paginator, SessionInterface $session): Response
    { 
        $rep=$this->getDoctrine()->getRepository(Participant::class);
        $idUser = $session->get("id");
        $participantA=$rep->showByUser($idUser);
        
        
        $parti = $paginator->paginate(
            $participantA, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
      
        return $this->render('participant/histo.html.twig', [
            'parti' => $parti,
           
        ]);
    }










     /**
     * @Route("/ajouterParticipant/{id}", name="ajouterParticipant")
     */
    public function ajouterP(Request $request,$id,MailerInterface $mailer, SessionInterface $session): Response
    { $idUser = $session->get("id");
       
        $participant=new Participant() ; // nouvelle instance 
        $form=$this->createForm(ParticipantType::class,$participant);
        $form->handleRequest($request);
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);
      
      $randonnee=$rep->find($id);
      $rep2=$this->getDoctrine()->getRepository(User::class);
     
      $User=$rep2->find($idUser);
if ($form->isSubmitted() && $form->isValid()) 
{
$participant=$form->getData();
$participant->setRandonnee($randonnee);
$participant->setUser($User);
$em=$this->getDoctrine()->getManager();
$em->persist($participant);
$em->flush();
$email=$User->getEmail();
$nomC=$User->getNom();
$prenom=$User->getPrenom();
$nom=$randonnee->getNomrando();
$duree=$randonnee->getDureeRando();
$email = (new Email())
->from('haweswebsite@gmail.com')
->to($email)
//->cc('cc@example.com')
//->bcc('bcc@example.com')
//->replyTo('fabien@example.com')
//->priority(Email::PRIORITY_HIGH)
->subject('Validation participation à '.$nom.' ')
->text('Bienvenu')
->html('<div style="border:2px solid green ;"> <h1>Bonjour   '.$nomC.' '.$prenom.' 
</h1>   
<a>
Site hawes vous remercie pour votre participation à notre randonnée  '.$nom.' </a> 
<br>
Pour une durée de :  <b>'.$duree.' </b>
<br>
Pour plus d informations n hésitez pas de nous contacter </div>');

/** @var Symfony\Component\Mailer\SentMessage $sentEmail */
$sentEmail = $mailer->send($email);
// $messageId = $sentEmail->getMessageId();

// ...




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
     * @Route("/supprimerParticipantFront/{id}", name="supprimerParticipantFront")
     */
    
    public function supprimerPFront($id): Response
    { $rep=$this->getDoctrine()->getRepository(Participant::class);
      $em=$this->getDoctrine()->getManager();
      $participant=$rep->find($id);
      $em->remove($participant);
      $em->flush(); 

        return $this->redirectToRoute('histo');
       
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









 /**
     * @Route("/listerpnr/{id}", name="listerpnr")
     */
    public function listerParNomRando($id): Response
    { 
        $rep=$this->getDoctrine()->getRepository(Participant::class);
        
        $participant =$rep-> showByRandonnee($id);
      
        return $this->render('participant/listerParticipantSelonRandonnee.html.twig', [
            'parti' => $participant,
           
        ]);
    }




/**
     * @Route("/modifierHisto/{id}", name="modifierHisto")
     */
    public function modifierHisto(Request $request, $id): Response
    { $rep=$this->getDoctrine()->getRepository(Participant::class);
        $participant=$rep->find($id); // nouvelle instance 
        $form=$this->createForm(ParticipantType::class,$participant);
        $form->handleRequest($request);
        
if ($form->isSubmitted()&& $form->isValid()) 
{

$em=$this->getDoctrine()->getManager();
$em->flush();
return $this->redirectToRoute('histo');
}


        return $this->render('participant/modifHisto.html.twig', [
            'formA' => $form->createView(),
        ]);
        

    }













}
