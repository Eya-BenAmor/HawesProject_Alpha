<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Session\Session;

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{


/**
     * @Route("/log", name="app_login")
     */
    public function login(Request $request): Response
    { 
        
        $rep=$this->getDoctrine()->getRepository(User::class);
        $user = new User();
        $form=$this->createForm(User1Type::class,$user);
        $form->handleRequest($request);
       
        if (isset($_POST['login-submit'])) {
           
            $mail = $request->request->get("email");
            $pswd = $request->request->get("pwd");
            $user= $rep->findOneBy(['email' => $mail]);
            if($pswd == $user->getMdp())
            {
                $session= new Session();
                $session->set('id',$user->getId());
                $session->set('nom',$user->getNom());
                $session->set('email',$user->getEmail());
                
                return $this->redirectToRoute('indexFront');
            }
              
            
           
        }
        return $this->render('user/login.html.twig', [
            'form' => $form->createView(),
        ]);
    }




    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(Request $request, UserRepository $userRepository, PaginatorInterface $paginator): Response
    {
        $rep = $this->getDoctrine()->getRepository(User::class);
        $user = $rep -> findAll();
        $user = $paginator->paginate(
            $user, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );
        return $this->render('user/index.html.twig', [
            'users' => $user,
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('indexFront', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/pdf", name="user_pdf", methods={"GET"})
     */
    public function pdf(UserRepository $userRepository)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $user = $userRepository->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('user/pdf.html.twig', [
            'user' => $user,
        ]);
        
        // Load HTML to Dompdf
        $dompdf->loadHtml($html);
        
        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }



 


}
