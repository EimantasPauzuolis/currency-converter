<?php

use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Config;

$factory->define(App\Conversion::class, function (Faker $faker) {
    $currencies = Config::get('currency');
    $randomCurrencies = array_rand($currencies, 2);
    $exchangeRate = $faker->randomFloat(4);
    $amount = $faker->numberBetween(1, 3000);
    $exchangeValue = $amount * $exchangeRate;

    return [
        'sourceCurrency' => $randomCurrencies[0],
        'targetCurrency' => $randomCurrencies[1],
        'exchangeRate' => $exchangeRate,
        'exchangeValue' => $exchangeValue,
        'inverseRate' => $exchangeRate,
        'inverseValue' => $exchangeValue,
        'amount' => $amount,
        'date' => Carbon::now()
    ];
});

$factory->state(App\Conversion::class, 'request', function ($faker) {
    $currencies = Config::get('currency');
    $randomCurrencies = array_rand($currencies, 2);
    $amount = $faker->numberBetween(1, 3000);
    return [
        'source' => $randomCurrencies[0],
        'target' => $randomCurrencies[1],
        'value' => $amount
    ];
});
