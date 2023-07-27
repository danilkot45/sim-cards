<?php

namespace App\Http\Requests\Tariff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTariffRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'max:255', Rule::unique('tariffs')->ignore($this->tariff->name, 'name')->whereNull('deleted_at')],
            'available_minutes' => 'required|min:3',
            'sms_count' => 'required|min:3',
            'cost' => 'required|min:3',
        ];
    }
}
