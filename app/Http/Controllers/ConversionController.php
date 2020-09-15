<?php

namespace App\Http\Controllers;

use App\Actions\ExchangeCurrency;
use App\Actions\SaveUserConversion;
use App\Actions\UpdateUserConversion;
use App\Http\Requests\ConversionCreateRequest;
use App\Http\Requests\ConversionRequest;
use App\Http\Requests\ConversionUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ConversionController extends Controller
{
    public function index()
    {
        return response(Auth::user()->conversions()->get(), 200);
    }

    public function store(ConversionCreateRequest $request)
    {
        $result = app(SaveUserConversion::class)->execute($request->all());
        return response($result, 200);
    }

    public function update(ConversionUpdateRequest $request, $id)
    {
        $result = app(UpdateUserConversion::class)->execute($id, $request->all());
        return response($result, 200);
    }
    public function convert(ConversionRequest $request)
    {
        $source = $request->input('source');
        $target = $request->input('target');
        $value = $request->input('value');
        $date = $request->input('date');
        $result = app(ExchangeCurrency::class)->execute($source, $target, $value, $date);
        return response($result, 200);
    }

    public function getCurrencyConversionCodes(Request $request)
    {
        return response(Config::get('currency'), 200);
    }
}
