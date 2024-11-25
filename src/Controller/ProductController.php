<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        return $this->render('product/product_show_all.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @return Response
     * contrôleur qui sert une page contenant la fiche d'un produit
     */
    #[Route('/product/show/{id}', name: 'product_show', requirements: ['id' => '\d+'])]
    public function show(Product $product): Response {

        return $this->render('product/product_show.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * Recherche des produits à partir d'un mot clé
     * @return Response
     */
    #[Route('/product/search', name: 'product_search', methods: ['POST'])]
    public function search(Request $request, ProductRepository $productRepository): Response {

        $keywordSearched = $request->request->get('searchProduct');
        $products = $productRepository->search($keywordSearched);
        $nbOfResults = count($products);

        return $this->render('product/product_show_all.html.twig', [
            'products' => $products,
            'nb_of_results' => $nbOfResults
        ]);
    }
}