<?php

namespace App\Http\Requests;

use App\Currency;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateCurrencyRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('currency_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'name'       => [
                'required'],
            'short_code' => [
                'required'],
            'position'   => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647'],
        ];
    }
}
