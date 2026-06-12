<?php

namespace App\Http\Requests;

use App\Enums\AnimalStatus;
use App\Models\Animal;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAdoptionApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Middleware will handle general auth
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'animal_id' => [
                'required',
                'exists:animals,id',
                Rule::unique('adoption_applications')->where(function ($query) {
                    return $query->where('user_id', $this->user()->id);
                }),
                function ($attribute, $value, $fail) {
                    $animal = Animal::find($value);
                    if ($animal && $animal->status !== AnimalStatus::AVAILABLE) {
                        $fail('To zwierzę nie jest obecnie dostępne do adopcji.');
                    }
                },
            ],
            'message' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'animal_id.unique' => 'Złożyłeś już wniosek o adopcję tego zwierzęcia.',
        ];
    }
}
