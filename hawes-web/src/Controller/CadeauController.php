<?php

namespace App\Controller;

use App\Entity\Cadeau;
use App\Form\CadeauType;
use App\Repository\CadeauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cadeau")
 */
class CadeauController extends AbstractController
{
    /**
     * @Route("/", name="cadeau_index", methods={"GET"})
     */
    public function index(CadeauRepository $cadeauRepository): Response
    {
        return $this->render('cadeau/index.html.twig', [
            'cadeaus' => $cadeauRepository->findAll(),
        ]);
    }





 /**
     * @Route("/listerFront1", name="listerFront1")
     */
    public function listerFront1(): Response
    { 
        $rep=$this->getDoctrine()->getRepository(Cadeau::class);
        
        $cadeau =$rep-> findAll();
      
        return $this->render('cadeau/listerFront1.html.twig', [
            'cadeau' => $cadeau,
           
        ]);
    }










    /**
     * @Route("/new", name="cadeau_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cadeau = new Cadeau();
        $form = $this->createForm(CadeauType::class, $cadeau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cadeau);
            $entityManager->flush();

            return $this->redirectToRoute('cadeau_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cadeau/new.html.twig', [
            'cadeau' => $cadeau,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cadeau_show", methods={"GET"})
     */
    public function show(Cadeau $cadeau): Response
    {
        return $this->render('cadeau/show.html.twig', [
            'cadeau' => $cadeau,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="cadeau_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Cadeau $cadeau, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CadeauType::class, $cadeau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('cadeau_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cadeau/edit.html.twig', [
            'cadeau' => $cadeau,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="cadeau_delete", methods={"POST"})
     */
    public function delete(Request $request, Cadeau $cadeau, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cadeau->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cadeau);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cadeau_index', [], Response::HTTP_SEE_OTHER);
    }










}
