<?php
namespace App\Controller\admin;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductController  extends  AbstractController {
    private $repository;
    private $em;

    /**
     * AdminProductController constructor.
     * @param ProductRepository $repository
     * @param ObjectManager $em
     */
    public function __construct(ProductRepository $repository, ObjectManager $em)
    {
        $this->em = $em;
        $this->repository = $repository;
    }

    /**
     * @Route("/admin", name="admin.product.index")
     * @return Response
     */
    public function index(): Response{
        $products = $this->repository->findAll();
        return $this->render('admin/product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/admin/{id}", name="admin.product.edit")
     * @param Product $product
     * @return Response
     */
    public function edit(Product $product, Request $request): Response{
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            $this->addFlash('success', 'Fichier bien édité.');
            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('admin/product/edit.html.twig', [
            'product'=>$product,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/admin/product/create", name="admin.product.new")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request){
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($product);
            $this->em->flush();
            $this->addFlash('success', 'Fichier bien ajouté.');
            return $this->redirectToRoute('admin.product.index');
        }

        return $this->render('admin/product/create.html.twig', [
            'product'=>$product,
            'form'=>$form->createView()
        ]);

    }

    /**
     * @Route("/admin/product/{id}", name="admin.product.delete", methods="DELETE")
     * @param Product $product
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Product $product, Request $request){
        if($this->isCsrfTokenValid('delete'.$product->getId(),$request->get('_token'))){
            $this->em->remove($product);
            $this->em->flush();
            $this->addFlash('success', 'Fichier bien supprimé.');
        }
        return $this->redirectToRoute('admin.product.index');
    }
}