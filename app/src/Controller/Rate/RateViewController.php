<?php

namespace App\Controller\Rate;

use App\Manager\RatesManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class RateViewController extends AbstractController
{
    private RatesManager $ratesManager;

    public function __construct(RatesManager $ratesManager)
    {
        $this->ratesManager = $ratesManager;
    }

    /**
     * @Route("/rates/{currency}", name="rate_view")
     */
    public function __invoke(string $currency, Request $request): Response
    {
        $rates = $this->ratesManager->getAllRatesWithPaginationByCurrency($currency, $request->query->getInt('page', 1), 20);

        if (0 == $rates->count()) {
            throw new NotFoundHttpException();
        }

        return $this->render('rate/view.html.twig', [
            'currency' => $currency,
            'rates' => $rates,
        ]);
    }
}
