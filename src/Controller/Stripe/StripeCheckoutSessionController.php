<?php

namespace App\Controller\Stripe;

use Stripe\Stripe;
use App\Entity\Cart;
use App\Repository\CartDetailsRepository;
use Stripe\Checkout\Session;
use App\Services\CartServices;
use App\Services\OrderServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeCheckoutSessionController extends AbstractController
{
    /**
     * @Route("/create-checkout-session", name="create_checkout_session")
     */
    public function index(CartServices $cartServices): Response

    {
        $cart = $cartServices->getFullCart();
        
        Stripe::setApiKey('sk_test_51JdF6JIfnQI75G2FhKY1WSM7DmJ0AXNaDf0OpY7XGeI8tXmGYgQOBgaSA362WNdUn6TN9wLtS2tSpErOVn0uaGy30066SG1jWG');
  
        $line_items = [];
        foreach ($cart['products'] as $data_product){
            
            $product = $data_product['product'];

            $line_items[] = [
                'price_data' => [
                    'currency' => 'eur',
                     'unit_amount' => $product->getPrice()*100,
                    'product_data' => [
                        'name' => $product->getName(),
                        //'images' => [$_ENV['YOUR_DOMAIN'] . '/uploads/products/' . $product->getImage()],
                    ],
                ],
                'quantity' => $data_product['quantity'],
            ];

        }
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $line_items,
            'mode' => 'payment',
            'success_url' => $_ENV['YOUR_DOMAIN'] . '/stripe-payment-success',
            'cancel_url' => $_ENV['YOUR_DOMAIN'] . '/stripe-payment-cancel',
        ]);
        
       
        

        
        return $this->redirect($checkout_session->url, 303);
    }
}