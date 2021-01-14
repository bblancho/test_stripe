<?php

namespace App\Controller;

use Stripe\Stripe;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }

    /**
     * @Route("/create-checkout-session", name="checkout")
     */
    public function checkout()
    {
        \Stripe\Stripe::setApiKey('sk_test_51I9e0MHP6ntZO1kaNhalJLjc9ORlLjo35PN032iAvzO8n4CrWryvuRzonWahMMOcVC3VOL1kIa2A9SSInFyIzprb00FAi11gaw');

            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                    'name' => 'T-shirt',
                    ],
                    'unit_amount' => 1500,
                ],
                'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $this->generateUrl("success", [], UrlGeneratorInterface::ABSOLUTE_URL),
                'cancel_url' => $this->generateUrl("error", [], UrlGeneratorInterface::ABSOLUTE_URL),
          ]);

          return new JsonResponse( [ 'id' => $session->id ] ) ;
    }


    /**
     * @Route("/success", name="success")
     */
    public function success()
    {
        return $this->render('default/success.html.twig');
    }

    /**
     * @Route("/error", name="error")
     */
    public function error()
    {
        return $this->render('default/error.html.twig');
    }


}
