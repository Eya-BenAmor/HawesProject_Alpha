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

/**
 * @Route("/competition")
 */
class CompetitionController extends AbstractController
{
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
    public function listerFront(): Response
    { 
        $rep=$this->getDoctrine()->getRepository(Competition::class);
        
        $competition =$rep-> findAll();
      
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





















}
