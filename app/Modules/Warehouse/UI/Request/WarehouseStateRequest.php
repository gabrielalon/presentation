<?php

namespace App\Modules\Warehouse\UI\Request;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseStateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'quantity' => 'required'
        ];
    }
}
