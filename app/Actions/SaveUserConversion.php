<?php


namespace App\Actions;


use App\Conversion;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SaveUserConversion
{
    public function execute($fields)
    {
        $conversion = new Conversion;
        $conversion->exchangeValue = $fields['exchangeValue'];
        $conversion->inverseValue = $fields['inverseValue'];
        $conversion->exchangeRate = $fields['exchangeRate'];
        $conversion->inverseRate = $fields['inverseRate'];
        $conversion->sourceCurrency = $fields['source'];
        $conversion->targetCurrency = $fields['target'];
        $conversion->amount = $fields['value'];
        $conversion->date = Carbon::parse($fields['date']);
        Auth::user()->conversions()->save($conversion);

        return $conversion;
    }
}
