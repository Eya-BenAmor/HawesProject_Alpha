<?php

namespace App\Controller;

use App\Entity\Cadeau;
use App\Entity\Competition;
use App\Form\CompetitionType;
use App\Repository\CompetitionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Notifications\NouveauCompetitionNotification;
use PHPMailer\PHPMailer\PHPMailer;
use Swift_SmtpTransport;
use Swift_Message;
use Swift_Mailer;
require_once 'C:\Users\Mezen Bayounes\Desktop\esprit\hawes-web\vendor\autoload.php';

/**
 * @Route("/competition")
 */
class CompetitionController extends AbstractController
{
    /**
   * @Route("/search", name="ajax_search")
   */
  public function searchAction(Request $request)
  {
      $em = $this->getDoctrine()->getManager();
      $nom = $request->get('q');
      $competition =$em->getRepository(Competition::class)->findEntitiesByNom($nom);
      if(!$competition ) {
          $result['competition ']['error'] = "competition introuvable :( ";
      } else {
          $result['competition '] = $this->getRealEntities($competition );
      }
      return new Response(json_encode($result));
  }
  public function getRealEntities($competition ){
      foreach ($competition  as $competition ){
          $realEntities[$competition ->getId()] = [$competition->getNom(),$competition->getDistance(),$competition->getDate(), $competition->getPrix()];
      }
      return $realEntities;
  }
  
  


/**
     * @Route("/acceuil", name="acceuil", methods={"GET"})
     */
    public function acceuil(): Response
    {
        return $this->render('competition/acceuil.html.twig', [
            'controller_name' => 'CompetitionController',
        ]);
    }

 /**
     * @Route("/indexFront", name="indexFront")
     */
    public function indexFront(): Response
    {
        return $this->render('competition/indexFront.html.twig', [
            'controller_name' => 'CompetitionController',
        ]);
    }


/**
     * @Route("/listerFront", name="listerFront")
     */
    public function listerFront(Request $request, PaginatorInterface $paginator): Response
    { 
        $rep=$this->getDoctrine()->getRepository(Competition::class);
        
        $competition =$rep-> findAll();
        $competition = $paginator->paginate(
            $competition, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1 // Nombre de résultats par page
        );
      
        return $this->render('competition/listerFront.html.twig', [
            'competition' => $competition,
           
        ]);
    }

   




    /**
     * @Route("/", name="competition_index", methods={"GET"})
     */
    public function index(CompetitionRepository $competitionRepository): Response
    {
        return $this->render('competition/index.html.twig', [
            'competitions' => $competitionRepository->findAll(),
        ]);
    }




/**
     * @Route("/listp", name="competition_listp", methods={"GET"})
     */
    public function listp(CompetitionRepository $competitionRepository)
    {



        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
       $competition= $competitionRepository->findAll();
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('competition/listp.html.twig', [
            'competition' => $competition,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);
    
       
    }






    /**
     * @Route("/new", name="competition_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $competition = new Competition();
        $form = $this->createForm(CompetitionType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($competition);
            $entityManager->flush();

            $this->notify_creation->notify();

            return $this->redirectToRoute('competition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('competition/new.html.twig', [
            'competition' => $competition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="competition_show", methods={"GET"})
     */
    public function show(Competition $competition): Response
    {
        return $this->render('competition/show.html.twig', [
            'competition' => $competition,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="competition_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Competition $competition, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompetitionType::class, $competition);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('competition_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('competition/edit.html.twig', [
            'competition' => $competition,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="competition_delete", methods={"POST"})
     */
    public function delete(Request $request, Competition $competition, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$competition->getId(), $request->request->get('_token'))) {
            $entityManager->remove($competition);
            $entityManager->flush();
        }

        return $this->redirectToRoute('competition_index', [], Response::HTTP_SEE_OTHER);
    }







/**
 * @var NouveauCompetitionNotification
 */
private $notify_creation;

/**
 * PublicationController constructor.
 * @param NouveauCompetitionNotification $notify_creation
 */
public function __construct(NouveauCompetitionNotification $notify_creation)
{
    $this->notify_creation = $notify_creation;
    
}











}
