<?php

namespace App\Controller;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController {
    private $repository;

    /**
     * @Route("/products", name="products.index")
     * @param ProductRepository $repository
     * @return Response
     */

    public function index(ProductRepository $repository): Response{
        $products = $repository->findAll();
        return $this->render('products/index.html.twig',[
            'current_menu'=> 'products',
            'products' => $products
        ]);
    }
    public function create(){
        // New product creation
        $product = new Product();
        $product->setTitle('iPhone 11');
        $product->setDescription('Il fait 64 GB.');
        $product->setPrice(1000);
        // EntityManager
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        return null;
    }
}