<?php

namespace App\Controller;

use App\Entity\ParticForm;
use App\Form\ParticFormType;
use App\Repository\ParticFormRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Notifications\NouveauParticFormNotification;
use PHPMailer\PHPMailer\PHPMailer;
use Swift_SmtpTransport;
use Swift_Message;
use Swift_Mailer;
//require_once 'C:\wamp64\www\hawes\vendor\autoload.php';

/**
 * @Route("/part")
 */
class ParticFormController extends AbstractController
{


    /**
 * @var NouveauParticFormNotification
 */
private $notify_creation;

/**
 * PublicationController constructor.
 * @param NouveauParticFormNotification $notify_creation
 */
public function __construct(NouveauParticFormNotification $notify_creation)
{
    $this->notify_creation = $notify_creation;
    
}

    /**
     * @Route("/new_back", name="new_back", methods={"GET", "POST"})
     */
    public function new_back(Request $request, EntityManagerInterface $entityManager): Response
    {
        $part = new ParticForm();
        $form = $this->createForm(ParticFormType::class, $part);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($part);
            $entityManager->flush();
            return $this->redirectToRoute('partic_form_index');
            
        }

        return $this->render('partic_form/new.html.twig', [
            'document' => $part,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/", name="partic_form_index", methods={"GET"})
     */
    public function index(ParticFormRepository $particFormRepository): Response
    {
        return $this->render('partic_form/index.html.twig', [
            'partic_forms' => $particFormRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="partic_form_new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $particForm = new ParticForm();
        $form = $this->createForm(ParticFormType::class, $particForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($particForm);
            $entityManager->flush();
            
     $this->notify_creation->notify();
            
         
            return $this->redirectToRoute('indexFront', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('partic_form/new_front.html.twig', [
            'formation' =>  $particForm,
            'form' => $form->createView(),
            
        ]);
    }

    /**
     * @Route("/{id}", name="partic_form_show", methods={"GET"})
     */
    public function show(ParticForm $particForm): Response
    {
        return $this->render('partic_form/show.html.twig', [
            'partic_form' => $particForm,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="partic_form_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ParticForm $particForm, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParticFormType::class, $particForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('partic_form_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('partic_form/edit.html.twig', [
            'partic_form' => $particForm,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="partic_form_delete", methods={"POST"})
     */
    public function delete(Request $request, ParticForm $particForm, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$particForm->getId(), $request->request->get('_token'))) {
            $entityManager->remove($particForm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('partic_form_index', [], Response::HTTP_SEE_OTHER);
    }
}
