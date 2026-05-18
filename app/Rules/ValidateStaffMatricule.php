<?php

namespace App\Rules;

use App\Helpers\MatriculeValidator;
use Illuminate\Contracts\Validation\Rule;

/**
 * ValidateStaffMatricule - Valide un matricule de personnel.
 */
class ValidateStaffMatricule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return MatriculeValidator::isValidStaffMatricule($value);
    }

    public function message(): string
    {
        return "Le matricule de personnel doit avoir le format: PER.CMR.2024.CDI";
    }
}
