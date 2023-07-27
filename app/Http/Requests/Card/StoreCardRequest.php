<?php

namespace App\Http\Requests\Card;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'imei' => ['required', 'size:15', Rule::unique('cards')->whereNull('deleted_at')],
            'number' => ['required', 'regex:/^(\\+7|8)\\d{10}$/', Rule::unique('cards')->whereNull('deleted_at')],
            'fio' => 'required',
            'tariff_id' => 'required|exists:tariffs,id',
        ];
    }
}
