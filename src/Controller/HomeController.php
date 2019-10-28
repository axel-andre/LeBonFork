<?php
namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController {

    /**
     * HomeController constructor.
     * @Route("/", name="home")
     * @param ProductRepository $repository
     * @return Response
     */
    public function index(ProductRepository $repository): Response{
        $products = $repository->findAll();
        dump($products);
        return $this->render('pages/home.html.twig',['products'=> $products]);
    }
}

