<?php

namespace App\Rules;

use App\Helpers\MatriculeValidator;
use Illuminate\Contracts\Validation\Rule;

/**
 * ValidateStudentMatricule - Valide un matricule d'étudiant.
 */
class ValidateStudentMatricule implements Rule
{
    public function passes($attribute, $value): bool
    {
        return MatriculeValidator::isValidStudentMatricule($value);
    }

    public function message(): string
    {
        return "Le matricule d'étudiant doit avoir le format: GL.CMRY22.23.K ou SR.CMRY22.23.K";
    }
}
