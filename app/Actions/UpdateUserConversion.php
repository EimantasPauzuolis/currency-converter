<?php


namespace App\Actions;


use App\Conversion;

class UpdateUserConversion
{
    public function execute($id, $fields)
    {
        $conversion = Conversion::findOrFail($id);
        $conversion->exchangeValue = $fields['exchangeValue'];
        $conversion->inverseValue = $fields['inverseValue'];
        $conversion->exchangeRate = $fields['exchangeRate'];
        $conversion->inverseRate = $fields['inverseRate'];
        $conversion->sourceCurrency = $fields['source'];
        $conversion->targetCurrency = $fields['target'];
        $conversion->amount = $fields['value'];
        $conversion->save();
        return $conversion;
    }
}
