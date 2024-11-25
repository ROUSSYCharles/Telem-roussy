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

    #[Route('/manage/product/edit/{id}', name: 'manage_product_edit', requirements: ['id' => '\d+'])]
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

        return $this->render('product/product_new.html.twig', [
            'form' => $form,
            'product' => $product,
        ]);
    }


    #[Route('manage/product/delete/{id}', name: 'manage_product_delete', requirements: ['id' => '\d+'])]
    public function delete(Product $product, EntityManagerInterface $em, Request $request): Response {
        //  Récupération du token soumis par le formulaire
        $submittedToken = $request->request->get('token');
        // Comparaison de ce token avec le token attendu
        if ($this->isCsrfTokenValid('delete-product', $submittedToken)) {
            $id = $product->getId();
            $em->remove($product);
            $em->flush();

            $this->addFlash('success', "Le produit $id a été supprimé");
        }

        $this->addFlash('error', "Le token pour la suppression du produit est invalide");
        return $this->redirectToRoute('product_show_all');
    }

    #[Route('manage/product/delete-confirm/{id}', name: 'manage_product_delete_confirm', requirements: ['id' => '\d+'])]
    public function deleteConfirm(Product $product): Response {
        return $this->render('product/product_delete_confirm.html.twig', [
            'product' => $product,
        ]);
    }
}