<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController
{
    /**
     * @return void
     * contrôleur qui sert une page contenant la liste de tous les produits
     */
    #[Route('/product/show-all', name: 'product_show_all')]
    public function showAll(ProductRepository $productRepository) : Response {
        $products = $productRepository->findAll();
        return $this->render('base.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @return Response
     * contrôleur qui sert une page contenant la fiche d'un produit
     */
    #[Route('/product/show/{id}', name: 'product_show', requirements: ['id' => '\d+'])]
    public function show(int $id, ProductRepository $productRepository): Response {
        $product = $productRepository->find($id);

        if(!$product) {
            throw new NotFoundHttpException('ce produit n\'existe pas');
        }

        return $this->render('product/product_show.html.twig', [
            'product' => $product
        ]);
    }
}