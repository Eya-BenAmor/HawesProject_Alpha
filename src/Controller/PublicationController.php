<?php

namespace App\Controller;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\Logger\DbalLogger;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Publication;
use App\Entity\User;
use App\Repository\PublicationRepository ;
use App\Form\PublicationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpFoundation\File\File;
use App\Notifications\NouveauPublicationNotification;
use PHPMailer\PHPMailer\PHPMailer;
use Dompdf\Dompdf;
use Dompdf\Options;

 

use Swift_SmtpTransport;
use Swift_Message;
use Swift_Mailer;



 



class PublicationController extends AbstractController
{   
    /**
     * @Route("/publication", name="publication")
     */
    public function index(): Response
    {
        return $this->render('publication/index.html.twig', [
            'controller_name' => 'PublicationController',
        ]);
    }

    /**
     * @Route("/pdfPublication", name="pdfPublication")
     */
    public function pdfPublication(): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled', true);
        
        $rep=$this->getDoctrine()->getRepository(Publication::class);
        
        $pub =$rep->findAll();
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
       
     
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('publication/pdf.html.twig', [
            'pub' => $pub
        ]);
      
        $options = new Options();

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }
    
    
    

     /**
     * @Route("/acceuil", name="acceuil")
     */
    public function indexFront(): Response
    {
        return $this->render('base-front.html.twig', [
            'controller_name' => 'PublicationController',
        ]);
    }
/**
     * @Route("/listpubfront", name="listpubfront")
     */
    public function listpubfront(Request $request, PaginatorInterface $paginator): Response
    { 
        $rep=$this->getDoctrine()->getRepository(publication::class);
        
        $publication =$rep-> findAll();
        //$paginator  = $this->get('knp_paginator');

        $publication = $paginator->paginate(
            $publication, // Requête contenant les données à paginer 
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );
      
        return $this->render('publication/listpubfront.html.twig', [
            'publication' => $publication,
           
        ]);
    }


    

/**
     * @Route("/listpub", name="listpub")
     */
    public function list(): Response
    {$rep=$this->getDoctrine()->getRepository(publication::class);

        $publication =$rep-> findAll();

        return $this->render('publication/listpubback.html.twig', [
            'publication' => $publication,
        ]);
    }


/**
     * @Route("/addpub", name="addpub")
     */
    public function add(Request $request): Response
    {
        $publication=new publication() ; // nouvelle instance 
        $form=$this->createForm(PublicationType::class,null);
        $form->handleRequest($request);
         $rep=$this->getDoctrine()->getRepository(User::class);
     
      $user=$rep->find('1');
        if ($form->isSubmitted() && $form->isValid() ) 
        {
            
        $publication=$form->getData();
        /** @var UploadedFile $File */
        $publication->setUser($user);
        $photoFile = $form->get('photo')->getData();

        // this condition is needed because the 'photo' field is not required
        // so the imagefile must be processed only when a file is uploaded
        if ($photoFile)  {
            $fileName = md5(uniqid()) . '.' . $photoFile->guessExtension();
            // Move the file to the directory where pictures are stored
            try {
                $photoFile->move(
                    $this->getParameter('photos_directory'),
                    $fileName
                ); 
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'pictureFilename' property to store the image file name
            // instead of its contents
            $publication->setPhoto($fileName);
        }
    $em=$this->getDoctrine()->getManager();
    $em->persist($publication);
    $em->flush();

     $this->notify_creation->notify();
     
    return $this->redirectToRoute('listpubfront');
    }
    


        return $this->render('publication/add.html.twig', [

            'formP' => $form->createView(),

           
        ]);

       

    }


    

    /**
     * @Route("/updatepub/{id}", name="updatepub")
     */
    public function update(Request $request, $id): Response
    { $rep=$this->getDoctrine()->getRepository(publication::class);
        $publication=$rep->find($id); 
        $form=$this->createForm(PublicationType::class,$publication);
        $form->handleRequest($request);
        $rep=$this->getDoctrine()->getRepository(User::class);
     
      $user=$rep->find('1');
if ($form->isSubmitted() && $form->isValid())
{
$publication=$form->getData();
   $publication->setUser($user);
        $photoFile = $form->get('photo')->getData();
// this condition is needed because the 'photo' field is not required
        // so the imagefile must be processed only when a file is uploaded
        if ($photoFile)  {
            $fileName = md5(uniqid()) . '.' . $photoFile->guessExtension();
            // Move the file to the directory where pictures are stored
            try {
                $photoFile->move(
                    $this->getParameter('photos_directory'),
                    $fileName
                ); 
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'pictureFilename' property to store the image file name
            // instead of its contents
            $publication->setPhoto($fileName);
            }
$em=$this->getDoctrine()->getManager();
$em->flush();
return $this->redirectToRoute('listpub');
}


        return $this->render('publication/update.html.twig', [
            'formP' => $form->createView(),
        ]);
        

    }


     /**
     * @Route("/deletepub/{id}", name="deletepub")
     */
    public function deletepub($id): Response
    { $rep=$this->getDoctrine()->getRepository(publication::class);
      $em=$this->getDoctrine()->getManager();
      $publication=$rep->find($id);
      $em->remove($publication);
      $em->flush(); 

        return $this->redirectToRoute('listpubfront');
       
    }


/**
 * @var NouveauPublicationNotification
 */
private $notify_creation;

/**
 * PublicationController constructor.
 * @param NouveauPublicationNotification $notify_creation
 */
public function __construct(NouveauPublicationNotification $notify_creation)
{
    $this->notify_creation = $notify_creation;
    
}
 /**
     * @Route("/listpubb/{id}", name="listpubb")
     */
    public function listpubb($id): Response
    {
        $rep=$this->getDoctrine()->getRepository(publication::class);

        $publication =$rep->ListPublicationById($id);

        return $this->render('publication/listpubback.html.twig', [
            'publication' => $publication,
        ]);
    }



  /**
   * @Route("/search", name="ajax_search")
   */
public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nom = $request->get('q');
        $publication =  $em->getRepository(publication::class)->findEntitiesByNom($nom);
        if(!$publication ) {
            $result['publication ']['error'] = "publication introuvable :( ";
        } else {
            $result['publication '] = $this->getRealEntities($publication );
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($publication ){
        foreach ($publication  as $publication ){
            $realEntities[$publication ->getId()] = [$publication->getNom(),$publication->getDescription(),$publication->getPhoto()];
        }
        return $realEntities;
    }

    /**
     * @Route("/listpubjson", name="listpubjson")
     */
    public function listjson(NormalizerInterface $Normalizer): Response

    {$rep=$this->getDoctrine()->getRepository(publication::class);

        $publication =$rep-> findAll();

          $jsonContent=$Normalizer->normalize($publication,'json',['groups'=>'post:read']);

        

        return new Response (json_encode($jsonContent));
    }
    

/**
     * @Route("/addpubjson", name="addpubjson")
     */
    public function addpubjson(Request $request,NormalizerInterface $Normalizer): Response
    {
        $em=$this->getDoctrine()->getManager();
        $publication=new publication() ;
        $publication->setNom($request->get('nom'));
         $publication->setDescription($request->get('description'));
          $publication->setPhoto($request->get('photo'));

       $em->persist($publication);
       $em->flush();
$this->notify_creation->notify();
    $jsonContent=$Normalizer->normalize($publication,'json',['groups'=>'post:read']);
    return new Response (json_encode($jsonContent));
       

    }

    /**
     * @Route("/updatepubjson/{id}", name="updatepubjson")
     */
    public function updatepubjson(Request $request,NormalizerInterface $Normalizer,$id): Response
    {
        $em=$this->getDoctrine()->getManager();
        $publication=$em->getRepository(publication::class)->find($id);
        $publication->setNom($request->get('nom'));
         $publication->setDescription($request->get('description'));
          $publication->setPhoto($request->get('photo'));

       $em->flush();

    $jsonContent=$Normalizer->normalize($publication,'json',['groups'=>'post:read']);
    return new Response ("publication modifiée".json_encode($jsonContent));
       

    }


    /**
     * @Route("/deletepubjson/{id}", name="deletepubjson")
     */
    public function deletepubjson(Request $request,NormalizerInterface $Normalizer,$id): Response
    {
        $em=$this->getDoctrine()->getManager();
        $publication=$em->getRepository(publication::class)->find($id);
     $em->remove($publication);
       $em->flush();

    $jsonContent=$Normalizer->normalize($publication,'json',['groups'=>'post:read']);
    return new Response ("publication supprimée".json_encode($jsonContent));
       

    }




    
}
