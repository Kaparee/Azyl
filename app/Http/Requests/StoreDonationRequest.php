<?php

namespace App\Http\Requests;

use App\Models\Fundraiser;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

// taka valdidacja
class StoreDonationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    // Zalogowany i nie zalogowany moze dawac donate
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */

    // Na jakiej zasadzie to walidujemy?
    public function rules(): array
    {
        return [
            'fundraiser_id' => [
                'required',
                'exists:fundraisers,id',

                // Customowo sprawdzamy czy poza tym ze istnieje to czy jest aktywna
                function ($attribute, $value, $fail) {
                    $fundraiser = Fundraiser::find($value);
                    if ($fundraiser && $fundraiser->status !== 1) {
                        $fail('Ta zbiórka została już zakończona');
                    }
                },
            ],
            'amount' => ['required', 'numeric', 'min:1', 'max:99999'],
        ];
    }
}
