<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Publication;
use App\Entity\Client;
use App\Repository\PublicationRepository ;
use App\Form\PublicationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;
use Symfony\Component\HttpFoundation\File\File;
use Knp\Component\Pager\PaginatorInterface;






class PublicationController extends AbstractController
{   
    /**
     * @Route("/publication", name="publication")
     */
    public function index(): Response
    {
        return $this->render('publication/index.html.twig', [
            'controller_name' => 'PublicationController',
        ]);
    }


     /**
     * @Route("/acceuil", name="acceuil")
     */
    public function indexFront(): Response
    {
        return $this->render('base-front.html.twig', [
            'controller_name' => 'PublicationController',
        ]);
    }
/**
     * @Route("/listpubfront", name="listpubfront")
     */
    public function listpubfront(Request $request, PaginatorInterface $paginator): Response
    { 
        $rep=$this->getDoctrine()->getRepository(publication::class);
        
        $publication =$rep-> findAll();
        //$paginator  = $this->get('knp_paginator');

        $publication = $paginator->paginate(
            $publication, // Requête contenant les données à paginer 
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3// Nombre de résultats par page
        );
      
        return $this->render('publication/listpubfront.html.twig', [
            'publication' => $publication,
           
        ]);
    }

/**
     * @Route("/listpub", name="listpub")
     */
    public function list(): Response
    {$rep=$this->getDoctrine()->getRepository(publication::class);

        $publication =$rep-> findAll();

        return $this->render('publication/listpubback.html.twig', [
            'publication' => $publication,
        ]);
    }


/**
     * @Route("/addpub", name="addpub")
     */
    public function add(Request $request): Response
    {
        $publication=new publication() ; // nouvelle instance 
        $form=$this->createForm(PublicationType::class,null);
        $form->handleRequest($request);
         $rep=$this->getDoctrine()->getRepository(Client::class);
     
      $client=$rep->find('1');
        if ($form->isSubmitted() && $form->isValid() ) 
        {
            
        $publication=$form->getData();
        /** @var UploadedFile $File */
        $publication->setIdclient($client);
        $photoFile = $form->get('photo')->getData();

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
            $publication->setPhoto($fileName);
        }
    $em=$this->getDoctrine()->getManager();
    $em->persist($publication);
    $em->flush();
    return $this->redirectToRoute('listpubfront');
    }
    


        return $this->render('publication/add.html.twig', [
            'formP' => $form->createView(),
        ]);

       

    }


    

    /**
     * @Route("/updatepub/{id}", name="updatepub")
     */
    public function update(Request $request, $id): Response
    { $rep=$this->getDoctrine()->getRepository(publication::class);
        $publication=$rep->find($id); 
        $form=$this->createForm(PublicationType::class,$publication);
        $form->handleRequest($request);
        $rep=$this->getDoctrine()->getRepository(Client::class);
     
      $client=$rep->find('1');
if ($form->isSubmitted() && $form->isValid())
{
$publication=$form->getData();
   $publication->setIdclient($client);
        $photoFile = $form->get('photo')->getData();
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
            $publication->setPhoto($fileName);
            }
$em=$this->getDoctrine()->getManager();
$em->flush();
return $this->redirectToRoute('listpub');
}


        return $this->render('publication/update.html.twig', [
            'formP' => $form->createView(),
        ]);
        

    }


     /**
     * @Route("/deletepub/{id}", name="deletepub")
     */
    public function deletepub($id): Response
    { $rep=$this->getDoctrine()->getRepository(publication::class);
      $em=$this->getDoctrine()->getManager();
      $publication=$rep->find($id);
      $em->remove($publication);
      $em->flush(); 

        return $this->redirectToRoute('listpub');
       
    }





    
}
