<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;


class HomeController extends AbstractController
{
    public function bonjour()
    {
        return new Response("Bonjour à tous et à toutes");
    }

    public function aurevoir()
    {
        return $this->redirectToRoute('home');
    }

    public function goToLinkedin()
    {
        return $this->redirect('https://www.linkedin.com/feed/');
    }

    public function renderBase()
    {
        return $this->render('base.html.twig', []);
    }

    #[Route('products', name: 'products_list', methods: ['GET'])]
    public function showProducts(Request $request)
    {
        $products = $request->query->get('product');

        dump($products);
        return $this->render('product.html.twig', ['products' => $products]);
    }

    #[Route('product/{id}', name: 'product_get', methods: ['GET'])]
    public function getProduct($id)
    {
        $products = ['ordinateur', 'clavier', 'souris', 'moniteur'];
        return $this->render('product.html.twig', ['productId' => $id, 'products' => $products]);

    }

}
