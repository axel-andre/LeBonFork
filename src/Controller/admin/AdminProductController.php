<?php
namespace App\Controller\admin;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductController  extends  AbstractController {
    private $repository;
    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @Route("/admin", name="admin.product.index")
     * @return Response
     */
    public function index(): Response{
        $products = $this->repository->findAll();
        return $this->render('admin/product/index.html.twig', compact('products'));
    }

    /**
     * @Route("/admin/{id}", name="admin.product.edit")
     * @param Product $product
     * @return Response
     */
    public function edit(Product $product): Response{
        return $this->render('admin/product/edit.html.twig', compact('product'));
    }

}