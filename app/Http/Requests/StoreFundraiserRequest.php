<?php

namespace App\Http\Requests;

use App\Enums\AnimalStatus;
use App\Models\Animal;
use App\Support\ValidationRules;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFundraiserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    // Zbiórke zakłada admin
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */

    // Validator taki
    public function rules(): array
    {
        return [
            'animal_id' => [
                'required',
                'exists:animals,id',

                function ($attribute, $value, $fail) {
                    $animal = Animal::find($value);
                    if ($animal && $animal->status === AnimalStatus::ADOPTED) {
                        $fail('Nie można utworzyć zbiórki dla zaadoptowanego zwierzęcia');
                    }
                },
            ],

            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'target_amount' => ['required', 'numeric', 'min:1'],
            'end_date' => ValidationRules::timestampDateRules(required: false, extra: ['after:today']),
        ];
    }

    public function messages(): array
    {
        return [
            'end_date.before' => 'Data zakończenia nie może być późniejsza niż 18.01.2038 (limit typu TIMESTAMP w bazie danych).',
        ];
    }
}
