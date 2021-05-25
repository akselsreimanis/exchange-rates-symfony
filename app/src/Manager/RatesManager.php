<?php

namespace App\Manager;

use App\Entity\Rate;
use App\Repository\RateRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class RatesManager
{
    private RateRepository $rateRepository;
    private PaginatorInterface $paginator;

    public function __construct(RateRepository $rateRepository, PaginatorInterface $paginator)
    {
        $this->rateRepository = $rateRepository;
        $this->paginator = $paginator;
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

    public function getAllRatesWithPagination(int $page, int $limit): PaginationInterface
    {
        $paginatedRates = $this->paginator->paginate($this->rateRepository->findBy(['date' => new \DateTime('now')]), $page, $limit);

        return $paginatedRates;
    }

    public function getAllRatesWithPaginationByCurrency(string $currency, int $page, int $limit): PaginationInterface
    {
        $paginatedRates = $this->paginator->paginate($this->rateRepository->findBy(['currency' => $currency]), $page, $limit);

        return $paginatedRates;
    }
}
