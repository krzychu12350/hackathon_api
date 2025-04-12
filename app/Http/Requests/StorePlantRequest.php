<?php

namespace App\Http\Requests;

use App\Enums\PlantWaterAmount;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StorePlantRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'preferred_water_amount' => ['required', new Enum(PlantWaterAmount::class)],
            'location' => 'required|string',
            'last_watering' => 'nullable|string|date',
            'plant_category_id' => 'required|exists:plant_categories,id',
        ];
    }
}
