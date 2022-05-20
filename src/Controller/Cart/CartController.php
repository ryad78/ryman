<?php

namespace App\Controller\Cart;

use App\Services\CartServices;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private $cartServices;

    public function __construct(CartServices $cartServices){
        $this->cartServices = $cartServices;
    }
    /**
     * @Route("/cart", name="cart")
     */
    public function index(): Response
    {   
        
        $cart = $this->cartServices->getFullCart();
        if(!$cart){
            return $this->redirectToRoute("home");
        }
        //dd($cartServices->getCart());
        return $this->render('cart/index.html.twig', [
            'cart' =>$cart
        ]);
    }
    /**
     * @Route("/cart/add/{id}", name="cart_add")
     */
    public function addToCart($id): Response{
        
        $this->cartServices->addToCart($id);
        return $this->redirectToRoute("cart");        
    }

    /**
     * @Route("/cart/delete/{id}", name="cart_delete")
     */
    public function deleteFromCart($id): Response{
        //$cartServices->deleteCart();
        $this->cartServices->deleteFromCart($id);

        return $this->redirectToRoute("cart");
        // dd($cartServices->getFullCart());
        // return $this->render('cart/index.html.twig', [
        //     'controller_name' => 'CartController',
        // ]);
    }
    /**
     * @Route("/cart/delete_all/{id}", name="cart_delete_all")
     */
    public function deleteAllToCart($id): Response{
        //$cartServices->deleteCart();
        $this->cartServices->deleteAllToCart($id);

        return $this->redirectToRoute("cart");

}
}
