<?php





namespace App\Controller;
use App\Entity\Randonnee ;
use App\Repository\RandonneeRepository;
use App\Form\RandoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class RandonneeController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(): Response
    {
        return $this->render('randonnee/index.html.twig', [
            'controller_name' => 'RandonneeController',
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
     */
    public function ajouterR(Request $request): Response
    {
        $randonnee=new Randonnee() ; // nouvelle instance 
        $form=$this->createForm(RandoType::class,$randonnee);
        $form->handleRequest($request);
if ($form->isSubmitted() && $form->isValid()) 
{
$randonnee=$form->getData();
$em=$this->getDoctrine()->getManager();
$em->persist($randonnee);
$em->flush();
return $this->redirectToRoute('listerRando');
}


        return $this->render('randonnee/ajouterRando.html.twig', [
            'formA' => $form->createView(),
        ]);
        

    }

    /**
     * @Route("/listerRando", name="listerRando")
     */
    public function listerR(): Response
    { 
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);
        
        $randonnee =$rep-> findAll();
      
        return $this->render('randonnee/listerRando.html.twig', [
            'rando' => $randonnee,
           
        ]);
    }


    /**
     * @Route("/supprimerRando/{id}", name="supprimerRando")
     */
    
    public function supprimerR($id): Response
    { $rep=$this->getDoctrine()->getRepository(Randonnee::class);
      $em=$this->getDoctrine()->getManager();
      $randonnee=$rep->find($id);
      $em->remove($randonnee);
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
    public function listerFront(): Response
    { 
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);
        
        $randonnee =$rep-> findAll();
      
        return $this->render('randonnee/listerFront.html.twig', [
            'rando' => $randonnee,
           
        ]);
    }
     /**
     * @Route("/chercherRando1", name="chercherRando1")
     */
    public function chercherR1(): Response
    {
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);

        $randonnee =$rep-> showByCategorie1();

        return $this->render('randonnee/listerFront.html.twig', [
            'rando' => $randonnee,
        ]);
    }
    /**
     * @Route("/chercherRando2", name="chercherRand2")
     */
    public function chercherR2(): Response
    {
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);

        $randonnee =$rep-> showByCategorie2();

        return $this->render('randonnee/listerFront.html.twig', [
            'rando' => $randonnee,
        ]);
    }
    /**
     * @Route("/chercherRando3", name="chercherRando3")
     */
    public function chercherR3(): Response
    {
        $rep=$this->getDoctrine()->getRepository(Randonnee::class);

        $randonnee =$rep-> showByCategorie3();

        return $this->render('randonnee/listerFront.html.twig', [
            'rando' => $randonnee,
        ]);
    }

}
