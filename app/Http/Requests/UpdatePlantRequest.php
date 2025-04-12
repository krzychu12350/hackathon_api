<?php

namespace App\Http\Requests;

use App\Enums\PlantWaterAmount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdatePlantRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'preferred_water_amount' => ['sometimes', new Enum(PlantWaterAmount::class)],
            'location' => 'sometimes|string',
            'last_watering' => 'nullable|string|date',
            'plant_category_id' => 'sometimes|exists:plant_categories,id',
        ];
    }
}
