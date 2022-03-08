<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Form\PlatType;
use App\Repository\PlatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/plat")
 */
class PlatController extends AbstractController
{



/**
   * @Route("/searchplat", name="ajax_searchplat")
   */
  public function searchAction(Request $request)
  {
      $em = $this->getDoctrine()->getManager();
      $nom = $request->get('r');
      $plat =  $em->getRepository(Plat::class)->findEntitiesByNom($nom);
      if(!$plat ) {
          $result['plat ']['error'] = "plat introuvable :( ";
      } else {
          $result['plat '] = $this->getRealEntities($plat );
      }
      return new Response(json_encode($result));
  }
  public function getRealEntities($plat ){
      foreach ($plat  as $plat ){
          $realEntities[$plat ->getId()] = [$plat->getNom(),$plat->getDescription(),$plat->getPrix()];
      }
      return $realEntities;
  }


    /**
    * @Route("/listp", name="plat_listp", methods={"GET"})
    */
   public function listp(PlatRepository $platRepository)
   {



       $pdfOptions = new Options();
       $pdfOptions->set('defaultFont', 'Arial');
       
       // Instantiate Dompdf with our options
       $dompdf = new Dompdf($pdfOptions);
      $plat= $platRepository->findAll();
       // Retrieve the HTML generated in our twig file
       $html = $this->renderView('plat/listp.html.twig', [
           'plat' => $plat,
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
     * @Route("/", name="plat_index", methods={"GET"})
     */
    public function index(PlatRepository $platRepository): Response
    {
        return $this->render('plat/index.html.twig', [
            'plats' => $platRepository->findAll(),
        ]);
    }



    /**
     * @Route("/listerFront1", name="listerFrontPlat")
     */
    public function listerFront1(Request $request, PaginatorInterface $paginator): Response
    { 
        $rep=$this->getDoctrine()->getRepository(Plat::class);
        
        $plat =$rep-> findAll();
        $plat = $paginator->paginate(
            $plat, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            1 // Nombre de résultats par page
        );
      
        return $this->render('plat/listerFront1.html.twig', [
            'plat' => $plat,
           
        ]);
    }


    /**
     * @Route("/new", name="plat_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $plat = new Plat();
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($plat);
            $entityManager->flush();

            return $this->redirectToRoute('plat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('plat/new.html.twig', [
            'plat' => $plat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plat_show", methods={"GET"})
     */
    public function show(Plat $plat): Response
    {
        return $this->render('plat/show.html.twig', [
            'plat' => $plat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="plat_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Plat $plat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PlatType::class, $plat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('plat_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('plat/edit.html.twig', [
            'plat' => $plat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="plat_delete", methods={"POST"})
     */
    public function delete(Request $request, Plat $plat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($plat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('plat_index', [], Response::HTTP_SEE_OTHER);
    }
}
