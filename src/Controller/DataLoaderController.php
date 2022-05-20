<?php

namespace App\Controller;

use App\Entity\Carrier;
use App\Entity\Product;
use App\Entity\Categories;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DataLoaderController extends AbstractController
{
    /**
     * @Route("/data", name="data_loader")
     */
    public function index(EntityManagerInterface $manager, UserRepository $repoUser): Response
    { // on a besoin du Manager parceque ces grace au managere quand stock dans la bdd
        //la on recupère mon fichier products.json
        //dd(__DIR__);  dirname pour sortir du controller 
        $file_products = dirname(dirname(__DIR__))."\products.json";
        $file_categories = dirname(dirname(__DIR__))."\categories.json";
        $file_carriers = dirname(dirname(__DIR__))."\carrier.json";
        // la je ves lire le contenu du fichier pour travailler sur ce dernier
        //$data_product = file_get_contents($file_product);
        //dd($data_product);
        //la je ves decoder le fichier .json pour le rendre en fichier php 
        $data_products = json_decode(file_get_contents($file_products))[0]->rows;
        $data_categories = json_decode(file_get_contents($file_categories))[0]->rows;
        $data_carriers = json_decode(file_get_contents($file_carriers))[0]->rows;
        //dd($data_product);
        //dd($data_categories);
        $categories = [];

        foreach ($data_categories as $data_category){
            $category = new Categories();
            $category->setName($data_category[1])
                    -> setImage($data_category[3]);
        $manager->persist($category);
            $categories[] = $category;
        }

        $carriers = [];

        foreach ($data_carriers as $data_carrier) {
            $carrier = new Carrier();
            $carrier->setName($data_carrier[1])
                     ->setDescription($data_carrier[2])
                     ->setPrice($data_carrier[3]);
            $manager->persist($carrier);
            $carriers[] = $carrier;
        }
        foreach ($data_products as $data_product){
            $product = new Product();
            $product->setName($data_product[1])
                    -> setDescription($data_product[3])
                    ->setPrice($data_product[4])
                    ->setIsBestSeller($data_product[5])
                    ->setIsNewArrival($data_product[5])
                    ->setIsFeatured($data_product[7])
                    ->setIsSpecialOffer($data_product[8])
                    ->setImage($data_product[9])
                    ->setQuantity($data_product[10])
                    ->setTags($data_product[12])
                    ->setSlug($data_product[13])
                    ->setCreatedAt(new \DateTime());
            $manager->persist($product);
            $products[] = $product;
        }
        //récupération d'un utilisateur id et lui donner le role admin
       $user = $repoUser-> find(1);
       $user->setRoles(['ROLE_ADMIN']);

        $manager->flush();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DataLoaderController.php',
        ]);
    }
}
