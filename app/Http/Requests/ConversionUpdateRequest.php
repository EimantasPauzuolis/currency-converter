<?php

namespace App\Http\Requests;

use App\Conversion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ConversionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $conversion = Conversion::find($this->route('id'));
        return Gate::allows('update-conversion', $conversion);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'exchangeValue' => 'required',
            'inverseValue' => 'required',
            'exchangeRate' => 'required',
            'inverseRate' => 'required',
            'source' => 'required',
            'target' => 'required',
            'value' => 'required',
        ];
    }
}
