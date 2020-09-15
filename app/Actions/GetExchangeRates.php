<?php


namespace App\Actions;


use App\Helpers\XMLToArray;
use GuzzleHttp\ClientInterface;

class GetExchangeRates
{
    protected $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    public function execute($baseCurrency = 'GBP', $date = null)
    {
        $url = $this->constructUrl($baseCurrency, $date);
        $response = $this->client->request('GET', $url);
        return (new XMLToArray())->convert($response->getBody()->getContents());
    }
    private function constructUrl($baseCurrency, $date)
    {
        if (isset($date)) {
            return env('CONVERSION_RATES_ENDPOINT_HISTORICAL') . '?currency_date=' . $date . '&base_currency_code=' . $baseCurrency . '&format_type=xml';
        }
        return env('CONVERSION_RATES_ENDPOINT') . $baseCurrency . '.xml';
    }
}
