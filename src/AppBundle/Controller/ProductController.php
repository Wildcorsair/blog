<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ProductController extends Controller
{
    /**
     * @Route("/products/create", name="productCreate")
     * @Method({"GET"})
     */
    public function createProductAction()
    {
        $category =  new Category();
        $category->setName('Computer Peripherals');

        $product = new Product();
        $product->setName('Keybord \"Logitech\"');
        $product->setPrice('150.99');
        $product->setDescription('Good keybord, life warranty!');
        $product->setCategory($category);

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->persist($category);

        $em->flush();

        return new Response('Saved new product with id '.$product->getId());
    }

    /**
     * @param integer $id Identifier of the product
     * @return string
     *
     * @Route("/products/show/{id}", name="productShow")
     * @Method({"GET"})
     */
    public function showProduct($id)
    {
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')
            ->find($id);
        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->render('AppBundle:Product:view.html.twig', array(
            'product' => $product
        ));
    }

    /**
     * @Route("/products/list", name="productList")
     * @Method({"GET"})
     */
    public function listProduct()
    {
        $products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findAll();

        if (!$products) {
            throw $this->createNotFoundException(
                'No products found'
            );
        }

        return $this->render('AppBundle:Product:list.html.twig', array(
            'products' => $products
        ));
    }

    /**
     * @Route("/products/search", name="productSearch")
     * @Method({"GET"})
     */
    public function searchAction()
    {
        $productName = 'Keyboard';
        $products = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findProductsByName($productName);
    }
}
