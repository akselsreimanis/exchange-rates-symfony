<?php

namespace App\Manager;

use App\Entity\Rate;
use App\Repository\RateRepository;

class RatesManager
{
    private RateRepository $rateRepository;

    public function __construct(RateRepository $rateRepository)
    {
        $this->rateRepository = $rateRepository;
    }

    public function createRateOrUpdate(\DateTimeInterface $dateTime, string $currency, float $currencyRate): ?Rate
    {
        $rate = $this->rateRepository->findOneBy(['date' => $dateTime, 'currency' => $currency]);

        if (null == $rate) {
            $rate = (new Rate())->setCurrency($currency)->setRate($currencyRate)->setDate($dateTime);
        } else {
            $rate->setRate($currencyRate);
        }

        return $rate;
    }
}
