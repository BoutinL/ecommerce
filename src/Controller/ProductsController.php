<?php

namespace App\Controller;

use App\Entity\Products;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/produits', name: 'app_products_')]
class ProductsController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('products/index.html.twig', [
            'controller_name' => 'Liste des produits',
        ]);
    }
    #[Route('/{slug}', name: 'details')]
    public function details(Products $product): Response
    { 
        return $this->render('products/details.html.twig', 
            ['product' => $product]
            // ou
            // compact('product') Transform le contenu de Products $product en tableau associatif
        );
    }
}