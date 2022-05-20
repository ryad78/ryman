<?php
namespace App\Services;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartServices{
    

    private $session;
    private $repoProduct;
    private $tva = 0.2;

    public function __construct(SessionInterface $session, ProductRepository $repoProduct)
    {
        $this->session = $session;
        $this->repoProduct = $repoProduct;
    }

    // ajouter un produit au panier par id
    public function addToCart($id){
        $cart = $this->getCart();
        if(isset($cart[$id])){
            // la si le produit est déja dans le panier alors j'incrémente
            $cart[$id]++;
        }else{
            // le produit n'est pas encore dans le panier alors je lui donne la valeur 1
            $cart[$id] = 1;
        }
        //la je met le panier à jour
        $this->updateCart($cart);
    }

    // supprimer un produit du panier par id
    public function deleteFromCart($id){
        $cart = $this->getCart();

        if(isset($cart[$id])){
            //produit déjà dans le panier 
            if($cart[$id] > 1){
                //produit existe plus d'une fois je décremente pour enlever une quantité
                $cart[$id]--;
            }else{
                unset($cart[$id]);// si le produit n'est pas supérieur a 1 alors ces égale a 1 alors on le retire du panier
            }
            $this->updateCart($cart);
        }
    }

    // méthode pour supprimer tous les prodits avec le meme id qui se trouve dans le panier
    public function deleteAllToCart($id){
        $cart = $this->getCart();

        if(isset($cart[$id])){
            //produit déjà dans le panier
            unset($cart[$id]);
            $this->updateCart($cart);
        }
    }

    // methode pour supprimer tous le panier 
    public function deleteCart(){
        $this->updateCart([]);
    }

    // méthode pour mettre a jour la panier dans la session 
    public function updateCart($cart){
        $this->session->set('cart', $cart);
        $this->session->set('cartData', $this->getFullCart());
    }

    // methode qui nous retourne le contenu du panier 
    public function getCart(){
        return $this->session->get('cart',[]);
    }
    

    public function getFullCart(){
        $cart = $this->getCart();

        $fullCart = [];
        $quantity_cart = 0;
        $subTotal = 0;

        foreach ($cart as $id => $quantity) {
            $product = $this->repoProduct->find($id);
            # code...
            if($product){
                // Produit récupéré avec succès grace au repository
                $fullCart['products'][]=
                [
                    "quantity" => $quantity,
                    "product" => $product
                ];
                $quantity_cart += $quantity;
                $subTotal += $quantity * $product->getPrice();
            }else{
                // id incorrecte 
                $this->deleteFromCart($id);
            }
        }

        $fullCart['data'] = [
            "quantity_cart" => $quantity_cart,
            "subTotalHT" => $subTotal,
            "Taxe" => round($subTotal*$this->tva,2),
            "subTotalTTC" => round(($subTotal + ($subTotal*$this->tva)), 2)
        ];

        return $fullCart;
    }






}