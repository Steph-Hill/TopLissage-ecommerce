<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class PanierService
{
    private $requestStack;
    private $em;
    private $tva = 0.2;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->em = $em;
    }

    /* Chercher le panier */
    public function getCart()
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
        return $session->get('cart',[]);
    }

    /* Mettre à jour le panier */
    public function updateCart($cart)
    {
        $request = $this->requestStack->getCurrentRequest();
        $session = $request->getSession();
        $session->set('cart', $cart);
        $session->set('cartData', $this->getFullCart());
    }
    /* Fonction ajout la quantité d'un article dans le panier */
    public function addToCart($id)
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {
            /* Le produit existe déjà, j'ajoute +1 à l'id */
            $cart[$id]++;
        } else {
            /* Le produit n'existe pas encore, on lui donne la valeur 1 à l'id */
            $cart[$id] = 1;
        }

        /* Met à jour le panier */
        $this->updateCart($cart);
    }

    /* Fonction supprimer du panier en décrémentant l'id */
    public function deleteFromCart($id)
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {
            /* Le produit existe déjà, on supprime -1 à l'id */
            $cart[$id]--;
        } else {
            /* Le produit n'existe pas encore, on le supprime du panier */
            unset($cart[$id]);
        }

        /* Met à jour le panier */
        $this->updateCart($cart);
    }

    /* Fonction supprimer tout un article du panier */
    public function deleteAllFromCart($id)
    {
        $cart = $this->getCart();

        if (isset($cart[$id])) {
            /* Tout supprimer */
            unset($cart[$id]);
            $this->updateCart($cart);
        }
    }

    /* Supprimer tout le panier */
    public function deleteCart()
    {
        $this->updateCart([]);
    }

    /* Ajout de la quantité avec le compteur d'id */
    public function getFullCart()
    {
        $cart = $this->getCart();
        $fullCart = [];
        $quantityCart = 0;
        $subTotal = 0;

        foreach ($cart as $id => $quantity) {
            /* Recherche de tous mes produits par rapport à l'id */
            $product = $this->em->getRepository(Product::class)->findOneBy(['id' => $id]);

            if ($product) {
                $fullCart['product'][] = [
                    'quantity' => $quantity,
                    'product' => $product
                ];
                $quantityCart += $quantity;
                $subTotal += $quantity * $product->getPrice()/100;
            } else {
                $this->deleteFromCart($id);
            }
        }

        $fullCart['data'] = [
            'quantity' => $quantityCart,
            'subTotalHT' => $subTotal,
            'taxe' => round($subTotal * $this->tva, 2),
            'subTotalTTC' => round(($subTotal + ($subTotal * $this->tva)), 2)
        ];

        return $fullCart;
    }
}
