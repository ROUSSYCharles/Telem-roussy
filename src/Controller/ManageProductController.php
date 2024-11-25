<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\Type\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class ManageProductController extends AbstractController
{
    #[Route('/manage/product/new', name: 'manage_product_new')]
    public function new(Request $request, EntityManagerInterface $em): Response {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);

        $form->add('Ajouter', SubmitType::class);
        $form->handleRequest($request);

        $product->setCreatedAt(new \DateTimeImmutable());

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Le produit a été ajouté au catalogue');
            return $this->redirectToRoute('product_show_all');
        }

        return $this->renderForm('product/product_new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/manage/product/edit/{id}', name: 'manage_product_edit')]
    public function edit(int $id, Product $product, ProductRepository $productRepository, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ProductType::class, $product);

        $form->add('updateProduct', SubmitType::class, [
            'label' => 'Modifier le produit',
            'attr' => [
                'class' => 'Button -no-danger -reverse',
            ]
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($product);
            $em->flush();

            $this->addFlash('success', 'Le produit a été mis à jour dans la bdd');
            return $this->redirectToRoute('product_show', ['id' => $id]);
        }

        return $this->renderForm('product/product_new.html.twig', [
            'form' => $form,
        ]);
    }
}