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
     * ProductController constructor.
     * @param ProductRepository $repository
     */

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * @Route("/products", name="products.index")
     * @param ProductRepository $repository
     * @return Response
     */
    public function index(ProductRepository $repository): Response{
        $products = $repository->findAndSort('DESC');
        return $this->render('products/index.html.twig',[
            'current_menu'=> 'products',
            'order'=>'DESC',
            'products' => $products
        ]);
    }

    /**
     * @Route("/products/sorted", name="products.sorted")
     * @param ProductRepository $repository
     * @return Response
     */
    public function sorted(ProductRepository $repository){
        $products = $repository->findAndSort('ASC');
        return $this->render('products/index.html.twig',[
            'current_menu'=> 'products',
            'order'=>'ASC',
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

    /**
     * @Route("/products/{slug}-{id}", name="products.show", requirements={"slug":"[a-z0-9\-]*"})
     * @param Product $product
     * @param String $slug
     * @return Response
     */
    public function show(Product $product, String $slug): Response{
        if($product->getSlug() !== $slug){
            return $this->redirectToRoute('product.show',[
                'id' => $product->getId(),
                'slug' => $product->getSlug(),

            ],301);
        }

        // IMPOSSIBLE
        return $this->render('products/show.html.twig',
            [
                'product'=> $product,
                'current_menu' => 'products'
            ]);
    }
}