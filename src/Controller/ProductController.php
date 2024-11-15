<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        #TODO : 50min video 10"
    }
}