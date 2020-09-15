<?php


namespace App\Actions;


class ExchangeCurrency
{
    protected $getExchangeRates;

    public function __construct(GetExchangeRates $getExchangeRates)
    {
        $this->getExchangeRates = $getExchangeRates;
    }

    public function execute($fromCurrency = 'GBP', $toCurrency = 'EUR', $amount = 1, $date = null)
    {
        $rates = $this->getExchangeRates->execute($fromCurrency, $date);
        $rateItems = $rates['item'];

        $item = collect($rateItems)->first(function ($item) use ($toCurrency) {
            return $item['targetCurrency'] === strtoupper($toCurrency);
        });

        // Same currency
        if (!isset($item)) {
            return [
                'exchangeValue' => $amount,
                'inverseValue' =>  $amount,
                'exchangeRate' => 1,
                'inverseRate' => 1,
                'date' => $rates['pubDate']
            ];
        }

        return [
            'exchangeValue' => $this->checkForCommasInNumber($item['exchangeRate']) * $amount,
            'inverseValue' =>  $this->checkForCommasInNumber($item['inverseRate']) * $amount,
            'exchangeRate' => $this->checkForCommasInNumber($item['exchangeRate']),
            'inverseRate' => $this->checkForCommasInNumber($item['inverseRate']),
            'date' => $rates['pubDate']
        ];
    }

    private function checkForCommasInNumber($number) {
        return str_replace( ',', '', $number);
    }
}
