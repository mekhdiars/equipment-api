<?php

namespace App\Http\Requests\Equipment;

use App\Rules\SerialNumberMatchesMask;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
            'equipment_type_id' => ['required', 'exists:equipment_types,id'],
            'serial_number' => [
                'required',
                new SerialNumberMatchesMask(),
                Rule::unique('equipment')
                    ->ignore($this->route('equipment'))
                    ->where(fn (Builder $query) =>
                    $query->where('equipment_type_id', $this->equipment_type_id)
                    ),
            ],
            'note' => ['nullable', 'string'],
        ];
    }
}
