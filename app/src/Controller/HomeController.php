<?php

namespace App\Controller;

use App\Manager\RatesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private RatesManager $ratesManager;

    public function __construct(RatesManager $ratesManager)
    {
        $this->ratesManager = $ratesManager;
    }

    /**
     * @Route("/", name="home")
     */
    public function index(Request $request): Response
    {
        $rates = $this->ratesManager->getAllRatesWithPagination($request->query->getInt('page', 1), 20);

        return $this->render('home/index.html.twig', [
            'rates' => $rates,
        ]);
    }
}
