<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\PropretySearch;
use App\Form\AdminType;
use App\Form\PropretySearchType;
use App\Repository\AdminRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPaginationInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\Serializer\Encoder\JsonEncoder;


/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_index", methods={"GET"})
     */
    public function index(Request $request, AdminRepository $adminRepository, PaginatorInterface $paginator): Response
    {
        $rep = $this->getDoctrine()->getRepository(Admin::class);
        $admin = $rep -> findAll();
        $admin = $paginator->paginate(
            $admin, // Requête contenant les données à paginer
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            6 // Nombre de résultats par page
        );

        return $this->render('admin/index.html.twig', [
            'admins' => $admin,
        ]);
    }

    /**
     * @Route("/new", name="admin_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $admin = new Admin();
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($admin);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/new.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_show", methods={"GET"})
     */
    public function show(Admin $admin): Response
    {
        return $this->render('admin/show.html.twig', [
            'admin' => $admin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Admin $admin, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/edit.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_delete", methods={"POST"})
     */
    public function delete(Request $request, Admin $admin, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admin->getId(), $request->request->get('_token'))) {
            $entityManager->remove($admin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/search", name="ajax_search")
     */
public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nom = $request->get('q');
        $admin =  $em->getRepository(Admin::class)->findEntitiesByNom($nom);
        if(!$admin ) {
            $result['admin ']['error'] = "admin introuvable :( ";
        } else {
            $result['admin '] = $this->getRealEntities($admin);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($admin){
        foreach ($admin  as $admin){
            $realEntities[$admin ->getId()] = [$admin->getNom()];

        }
        return $realEntities;
    }

    /**
     * @Route("/logina", name="ad_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('admin/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/pdf", name="admin_pdf", methods={"GET"})
     */
    public function pdf(AdminRepository $adminRepository)
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');
        
        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $admin = $adminRepository->findAll();

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('admin/pdf.html.twig', [
            'admin' => $admin,
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

    /**
     * @Route("/xlsx", name="admin_xlsx", methods={"GET"})
     */
    public function xlsx()
    {
        $spreadsheet = new Spreadsheet();
        
        /* @var $sheet \PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet */
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
        $sheet->setTitle("My First Worksheet");
        
        // Create your Office 2007 Excel (XLSX Format)
        $writer = new Xlsx($spreadsheet);
        
        // Create a Temporary file in the system
        $fileName = 'my_first_excel_symfony4.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);
        
        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);
        
        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }
}
