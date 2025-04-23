<?php

namespace App\Rules;

use App\Models\EquipmentType;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SerialNumberMatchesMask implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $typeId = request('equipment_type_id');
        $mask = EquipmentType::find($typeId)->mask_sn;

        $pattern = '/^' . strtr($mask, [
                'N' => '[0-9]',
                'A' => '[A-Z]',
                'a' => '[a-z]',
                'X' => '[A-Z0-9]',
                'Z' => '[-_@]',
            ]) . '$/';

        if (! preg_match($pattern, $value)) {
            $fail('Serial number does not match mask ' . $mask . '.');
        }
    }
}
