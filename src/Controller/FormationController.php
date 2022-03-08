<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use App\Repository\FormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;


/**
 * @Route("/formation")
 */
class FormationController extends AbstractController
{


  /**
   * @Route("/searchformation", name="ajax_searchformation")
   */
  public function searchAction(Request $request)
  {
      $em = $this->getDoctrine()->getManager();
      $nom = $request->get('f');
      $formation =$em->getRepository(Formation::class)->findEntitiesByNom($nom);
      if(!$formation ) {
          $result['formation ']['error'] = "formation introuvable :( ";
      } else {
          $result['formation '] = $this->getRealEntities($formation );
      }
      return new Response(json_encode($result));
  }
  public function getRealEntities($formation ){
      foreach ($formation  as $formation){
          
$realEntities[$formation ->getId()] = [$formation->getNomeq(),$formation->getDomaine(),$formation->getDuree(),$formation->getNomform(),$formation->getPlan(),$formation->getDate()];
      }
      return $realEntities;
  }




/**
     * @Route("/listp", name="formation_listp", methods={"GET"})
     */
    public function listp(FormationRepository $formationrepository )
    {

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
       $cadeau= $formationrepository->findAll();
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('formation/listp.html.twig', [
            'form' => $cadeau,
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
     * @Route("/", name="formation_index", methods={"GET"})
     */
    public function index(FormationRepository $formationRepository): Response
    {
        return $this->render('formation/index.html.twig', [
            'formations' => $formationRepository->findAll(),
        ]);
    }

   /**
     * @Route("/listerFront", name="listerFrontFormation")
     */
    public function listerFront(Request $request, PaginatorInterface $paginator): Response
    { 
        $rep=$this->getDoctrine()->getRepository(Formation::class);
        
        $formation =$rep-> findAll();
        $formation = $paginator->paginate(
            $formation, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1 // Nombre de résultats par page
        );
      
        return $this->render('formation/listformation.html.twig', [
            'form' => $formation,
           
        ]);
    }


    /**
     * @Route("/info/{id}", name="info")
     */
    public function detaille(string $id)
    { 
        $rep=$this->getDoctrine()->getRepository(Formation::class);
        $form =$rep-> find($id);
        echo "<script>console.log('Debug Objects: " . $form . "' );</script>";

        return $this->render('formation/detaille.html.twig', [
            'form' => $form,
           
        ]);

    }


    /**
     * @Route("/indexFront", name="indexFront")
     */
    public function indexFront(): Response
    {
        return $this->render('formation/indexFront.html.twig', [
            'controller_name' => 'FormationController',
        ]);
    }



    /**
     * @Route("/new", name="formation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($formation);
            $entityManager->flush();

            return $this->redirectToRoute('formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formation/new.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="formation_show", methods={"GET"})
     */
    public function show(Formation $formation): Response
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="formation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Formation $formation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formation/edit.html.twig', [
            'formation' => $formation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="formation_delete", methods={"POST"})
     */
    public function delete(Request $request, Formation $formation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($formation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('formation_index', [], Response::HTTP_SEE_OTHER);
    }
}
