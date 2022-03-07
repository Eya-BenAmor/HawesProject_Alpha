<?php

namespace App\Controller;

use App\Entity\Plat;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart", name="cart_")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(SessionInterface $session, PlatRepository $platRepository)
    {
        $panier = $session->get("panier", []);

        // nasn3ou les donnees
        $dataPanier = [];
        $total = 0;

        foreach($panier as $id => $quantite){
            $plats = $platRepository->find($id);
            $dataPanier[] = [
                "plats" => $plats,
                "quantite" => $quantite
            ];
            $total += $plats->getPrix() * $quantite;
        }

        return $this->render('cart/index.html.twig', compact("dataPanier", "total"));
    }

    /**
     * @Route("/add/{id}", name="add")
     */
    public function add(Plat $plats, SessionInterface $session)
    {
        // nekhtou panier taa tawa
        $panier = $session->get("panier", []);
        $id = $plats->getId();

        if(!empty($panier[$id]))
        {
            $panier[$id]++;
        }
        else
        {
            $panier[$id] = 1;
        }

        // sauvegarde fi session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function remove(Plat $plats, SessionInterface $session)
    {
        // nekhtou panier taa tawa
        $panier = $session->get("panier", []);
        $id = $plats->getId();

        if(!empty($panier[$id])){
            if($panier[$id] > 1){
                $panier[$id]--;
            }else{
                unset($panier[$id]);
            }
        }

        // sauvegarde fi session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Plat $plats, SessionInterface $session)
    {
        // nekhtou panier taa tawa
        $panier = $session->get("panier", []);
        $id = $plats->getId();

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        // sauvegarde fi session
        $session->set("panier", $panier);

        return $this->redirectToRoute("cart_index");
    }

    /**
     * @Route("/delete", name="delete_all")
     */
    public function deleteAll(SessionInterface $session)
    {
        $session->remove("panier");

        return $this->redirectToRoute("cart_index");
    }

}
