<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\HomeSlider;
use App\Entity\SearchProduct;
use App\Form\SearchProductType;
use App\Repository\ProductRepository;
use App\Repository\HomeSliderRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $repoProduct, HomeSliderRepository $repoHomeSlider): Response
    {

        $products = $repoProduct->findAll();
        $homeSlider = $repoHomeSlider->findBy(['isDisplayed'=>true]);
        //dd($homeSlider);
        // comme bestseller ces un boulean ca va prendre true ou false alors moi je met 1 pour true parceque en base de donner ces 0 pour false et 1 pour un besteseller
        $productBestSeller = $repoProduct->findByIsBestSeller(1);
        $productSpecialOffer =$repoProduct->findByIsSpecialOffer(1);
        $productNewArrival = $repoProduct->findByIsNewArrival(1);
        $productFeatured = $repoProduct->findByIsFeatured(1);

        // dd([$productBestSeller, $productSpecialOffer, $productNewArrival,$productFeatured ]);

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'products' => $products,
            'productBestSeller' => $productBestSeller,
            'productSpecialOffer' => $productSpecialOffer,
            'productNewArrival' => $productNewArrival,
            'productFeatured' => $productFeatured,
            'homeSlider' =>$homeSlider,
        ]);
    }

    /**
     * @Route("/products/{slug}", name="product_details")
     */
    public function show (?Product $product): Response{
        if(!$product){ //si le produit nes pas deffinie je return sur home
            return $this->redirectToRoute("home");
        }// sinon je return au twig single_product.html.twig
        return $this->render("home/single_product.html.twig", [
            'product' => $product
        ]);
    }
    /**
     * @Route("/produit", name="produit")
     */
    public function Produit(ProductRepository $repoProduct, Request $request): Response
    {

        $products = $repoProduct->findAll();
        $search = new SearchProduct();

        // je déffinie mon formulaire de filtre par categories, prix et tags
        $form = $this->createForm(SearchProductType::class, $search); 
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           $products = $repoProduct->findWithSearch($search);    
        }
    

        return $this->render('home/produit.html.twig', [
            'products' => $products,
            'search' => $form->createView()
            
        ]);
    }
}
