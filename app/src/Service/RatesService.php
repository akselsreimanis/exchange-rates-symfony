<?php

namespace App\Service;

use App\Manager\RatesManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RatesService
{
    public const RSS_FEED_LINK = 'https://www.bank.lv/vk/ecb_rss.xml';

    private HttpClientInterface $client;
    private EntityManagerInterface $entityManager;
    private RatesManager $ratesManager;

    public function __construct(
        HttpClientInterface $client,
        EntityManagerInterface $entityManager,
        RatesManager $ratesManager
    ) {
        $this->client = $client;
        $this->entityManager = $entityManager;
        $this->ratesManager = $ratesManager;
    }

    public function importDataFromRss(): void
    {
        $rssDataFeed = new \SimpleXMLElement($this->getStringDataFromRSS());

        foreach ($rssDataFeed->channel->item as $item) {
            $date = new \DateTime($item->pubDate);
            $ratesString = trim($item->description);
            $explodedData = explode(' ', $ratesString);

            for ($i = 0; $i < count($explodedData); ++$i) {
                if (0 == $i % 2) {
                    $rate = $this->ratesManager->createRateOrUpdate($date, $explodedData[$i], (float) $explodedData[$i + 1]);

                    $this->entityManager->persist($rate);
                }
            }
        }

        $this->entityManager->flush();
    }

    private function getStringDataFromRSS(): string
    {
        try {
            $response = $this->client->request(Request::METHOD_GET, self::RSS_FEED_LINK);
        } catch (TransportExceptionInterface $exception) {
            throw new \Exception($exception->getMessage());
        }

        return $response->getContent();
    }
}
