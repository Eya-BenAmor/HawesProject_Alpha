<?php

namespace App\Controller;
use App\Entity\Randonnee ;
use App\Entity\Participant ;
use App\Entity\User ;
use App\Repository\RandonneeRepository;
use App\Form\RandoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\HttpFoundation\JsonResponse ;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\Session\Flash\AutoExpireFlashBag;

class RandonneeController extends AbstractController

{

 


    
 /**
     * @Route("/stats", name="stats")
     */
    public function statistiques(){
        // On va chercher toutes les catégories
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);
        $randonnees = $rep->findAll();

        $nomRando = [];
        $nbParticipant = [];
        $couleur = [];
       

        
        foreach($randonnees as $rando){
            $nomRando[] = $rando->getNomRando();
            $nbParticipant[] = count($rando->getParticipant());
            $couleur[] =$rando->getCouleur();
        }

        
       

        return $this->render('Randonnee/stat.html.twig', [
            'Nom' => json_encode($nomRando),
        
            'Count' => json_encode($nbParticipant),
            'Couleur' => json_encode($couleur),
           
        ]);
    } 

  /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
       
       
        $rep2=$this->getDoctrine()->getRepository(Randonnee::class);
        $em=$this->getDoctrine()->getManager();
        $randonnee2 =$rep2-> findAll();
        date_default_timezone_set("Africa/Tunis");
        $date=date("d-m-Y");
        
        foreach ($randonnee2 as $rando2){
            $date2=$rando2->getDateRando()->format('d-m-Y');
           if(strtotime($date)>= strtotime($date2)){
            $em->remove($rando2);
        
            $em->flush(); 
         
         
           }
        }
        return $this->redirectToRoute('listerRando');
    



    }











    /**
     * @Route("/pdf/{id}", name="pdf")
     */
    public function pdf($id): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        $pdfOptions->set('isRemoteEnabled', true);
        
        $rep=$this->getDoctrine()->getRepository(Participant::class);
        
        $participant =$rep-> showByRandonnee($id);
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        
       
     
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('randonnee/pdf.html.twig', [
            'parti' => $participant
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
     * @Route("/indexFront", name="indexFront")
     */
    public function indexFront(): Response
    {
        return $this->render('randonnee/indexFront.html.twig', [
            'controller_name' => 'RandonneeController',
        ]);
    }
     /**
     * @Route("/ajouterRando", name="ajouterRando")
     * @Route LoggerInterface $logger
     */
    public function ajouterR(Request $request, LoggerInterface $logger): Response
    {
        $randonnee=new Randonnee() ; // nouvelle instance 
        $form=$this->createForm(RandoType::class,$randonnee);
        $form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid()) 
{
$randonnee=$form->getData();
$photoFile = $form->get('image')->getData();

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
            $randonnee->setImage($fileName);
        }
$em=$this->getDoctrine()->getManager();
$em->persist($randonnee);
$request->getSession()->getFlashBag()->add('notice', 'Une randonnée ajoutée avec succes ');
$em->flush();

return $this->redirectToRoute('listerRando');

}
else {
     $logger->info($request);
}

        return $this->render('randonnee/ajouterRando.html.twig', [
            'formA' => $form->createView(),
        ]);
        

    }

    /**
     * @Route("/listerRando", name="listerRando")
     */
    public function listerR(Request $request, PaginatorInterface $paginator): Response
    { 


        $rep=$this->getDoctrine()->getRepository(Randonnee::class);
        
        $randonnee =$rep-> findAll();
        $rando = $paginator->paginate(
            $randonnee, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            2 // Nombre de résultats par page
        );
      
      return $this->render('randonnee/listerRando.html.twig', [
            'rando' =>  $rando,
           
        ]);
      




    }
     

    /**
     * @Route("/supprimerRando/{id}", name="supprimerRando")
     */
    
    public function supprimerR(Request $request,$id): Response
    { $rep=$this->getDoctrine()->getRepository(Randonnee::class);
      $em=$this->getDoctrine()->getManager();
      $randonnee=$rep->find($id);
      $em->remove($randonnee);
      $request->getSession()->getFlashBag()->add('notice', 'Une randonnée supprimée avec succes ');
      $em->flush(); 
     
        return $this->redirectToRoute('listerRando');
       
    }


     /**
     * @Route("/modifierRando/{id}", name="modifierRando")
     */
    public function modifierR(Request $request, $id): Response
    { $rep=$this->getDoctrine()->getRepository(Randonnee::class);
        $randonnee=$rep->find($id); // nouvelle instance 
        $form=$this->createForm(RandoType::class,$randonnee);
        $form->handleRequest($request);
if ($form->isSubmitted()&& $form->isValid()) 
{
    $photoFile = $form->get('image')->getData();

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
        $randonnee->setImage($fileName);
    }
$em=$this->getDoctrine()->getManager();
$em->flush();
return $this->redirectToRoute('listerRando');
}


        return $this->render('randonnee/modifRando.html.twig', [
            'formA' => $form->createView(),
        ]);
        

    }

     /**
     * @Route("/listerFront", name="listerFront")
     */
    public function listerFront(Request $request, PaginatorInterface $paginator): Response
    { 
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);
        
        $randonnee =$rep-> findAll();

        $rando = $paginator->paginate(
            $randonnee, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1 // Nombre de résultats par page
        );
      
        return $this->render('randonnee/listerFront.html.twig', [
            'rando' => $rando,
           
        ]);
    }
     /**
     * @Route("/chercherRando1", name="chercherRando1")
     */
    public function chercherR1(Request $request, PaginatorInterface $paginator): Response
    {
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);

        $randonnee =$rep-> showByCategorie1();
        $rando = $paginator->paginate(
            $randonnee, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1 // Nombre de résultats par page
        );

        return $this->render('randonnee/listerFront.html.twig', [
            'rando' => $rando,
        ]);
    }
    /**
     * @Route("/chercherRando2", name="chercherRand2")
     */
    public function chercherR2(Request $request, PaginatorInterface $paginator): Response
    {
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);

        $randonnee =$rep-> showByCategorie2();
        $rando = $paginator->paginate(
            $randonnee, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1 // Nombre de résultats par page
        );

        return $this->render('randonnee/listerFront.html.twig', [
            'rando' => $rando,
        ]);
    }
    /**
     * @Route("/chercherRando3", name="chercherRando3")
     */
    public function chercherR3(Request $request, PaginatorInterface $paginator): Response
    {
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);

        $randonnee =$rep-> showByCategorie3();
        $rando = $paginator->paginate(
            $randonnee, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1// Nombre de résultats par page
        );
        return $this->render('randonnee/listerFront.html.twig', [
            'rando' => $rando,
        ]);
    }




 /**
     * @Route("/modifierRandoNote/{id}", name="modifierRandoNote")
     */
    public function modifierNote( Request $request,$id): Response
    { $rep=$this->getDoctrine()->getRepository(Randonnee::class);
        $randonnee=$rep->find($id); // nouvelle instance 
      
       
        $note=$randonnee->getNote();
        $maValeur = $request->request->get("note");
       if($note==0)
       {

        $randonnee->setNote($maValeur);

       }
       else 
       {
        if ($note<$maValeur)
        {$notef=$note+0.5;
 $randonnee->setNote($notef);
    }
    else if($note>$maValeur) 
    {
        $notef=$note-0.5;
        $randonnee->setNote($notef); 
    }
           
     else 
     {
        $randonnee->setNote($note); 
     }      
            
       }
$em=$this->getDoctrine()->getManager();
$em->flush();

return $this->redirectToRoute('listerFront');
}









     /**
     * @Route("/listerJson", name="listerJson")
     */
    public function listerJson(NormalizerInterface $Normalizer): Response
    { 
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);
        
        $randonnee =$rep-> findAll();

      $jsonContent=$Normalizer->normalize($randonnee, 'json',['groups'=>'post:read']);
      
       
        return new Response(json_encode($jsonContent));
    }


 /**
     * @Route("/ajouterJson", name="ajouterJson")
     */
    public function ajouterJson(Request $request,NormalizerInterface $Normalizer): Response
    { 
        $randonnee=new Randonnee() ; // nouvelle instance 
        $em=$this->getDoctrine()->getManager();

        $randonnee->setNomRando($request->get('nomRando'));
        $randonnee->setDestination($request->get('destination'));
        $randonnee->setDescription($request->get('description'));
     
        $randonnee->setDureeRando($request->get('dureeRando'));
       




$em->persist($randonnee);
$em->flush();
$jsonContent=$Normalizer->normalize($randonnee, 'json',['groups'=>'post:read']);
return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/supprimerJson/{id}", name="supprimerJson")
     */
    public function supprimerJson(Request $request,NormalizerInterface $Normalizer,$id): Response
    { 
       
        $em=$this->getDoctrine()->getManager();
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);
        
        $randonnee =$rep-> find($id);
        $em->remove($randonnee);
        $em->flush();
$jsonContent=$Normalizer->normalize($randonnee, 'json',['groups'=>'post:read']);
return new Response("suppression avec succes".json_encode($jsonContent));
    }


    /**
     * @Route("/modifierJson/{id}", name="modifierJson")
     */
    public function modifierJson(Request $request,NormalizerInterface $Normalizer,$id): Response
    { 
       
        $em=$this->getDoctrine()->getManager();
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);
        
        $randonnee =$rep-> find($id);
        $randonnee->setNomRando($request->get('nomRando'));
        $randonnee->setDestination($request->get('destination'));
        $randonnee->setDescription($request->get('description'));
       
        $em->flush();
$jsonContent=$Normalizer->normalize($randonnee, 'json',['groups'=>'post:read']);
return new Response("mise a jour avec succes".json_encode($jsonContent));
    }







/**
  
   * @Route("/search", name="ajax_search")
  
   */
  public function searchAction(Request $request)
  {
      $em = $this->getDoctrine()->getManager();

      $requestString = $request->get('q');

      $entities =  $em->getRepository(Randonnee::class)->showByDestination($requestString);

      if(!$entities) {
          $result['entities']['error'] = "Pas de randonnees";
      } else {
          $result['entities'] = $this->getRealEntities($entities);
      }

      return new Response(json_encode($result));
  }

  public function getRealEntities($entities){

      foreach ($entities as $entity){
          $realEntities[$entity->getNomRando()] = $entity->getNomRando();
      }

      return $realEntities;
  }



    
}