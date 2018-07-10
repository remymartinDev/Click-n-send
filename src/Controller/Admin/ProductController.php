<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


/**
 * @Route("/api/product")
 */
class ProductController extends Controller
{
    /**
     * @Route("s", name="product_list", methods="GET")
     */
    public function list(ProductRepository $productRepository, ConfiguredSerializer $configuredSerializer): Response
    {
        $products = $productRepository->findInactivProducts(1);
        
        //on utilise un service créé par nos soin pour configurer le serializer
        $json = $configuredSerializer->getConfiguredSerializer()->serialize($products, 'json');

        return new Response($json);
    }
}