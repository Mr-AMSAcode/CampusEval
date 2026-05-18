<?php

namespace App\Helpers;

/**
 * MatriculeValidator - Validateur de matricules CampusEval
 * 
 * Format:
 * - Étudiants: GL.CMRY22.23.K ou SR.CMRY22.23.K
 * - Personnel: PER.CMR.2024.CDI
 */
class MatriculeValidator
{
    /**
     * Formats de matricule acceptés.
     */
    public const STUDENT_PREFIX_GL = 'GL';
    public const STUDENT_PREFIX_SR = 'SR';
    public const STAFF_PREFIX = 'PER';
    public const STAFF_SUFFIX = 'CDI';

    /**
     * Valider un matricule d'étudiant.
     * Format: GL.CMRY22.23.K ou SR.CMRY22.23.K
     */
    public static function isValidStudentMatricule(string $matricule): bool
    {
        // Accepter GL.* ou SR.*
        return preg_match('/^(GL|SR)\.[A-Z0-9]+\.[0-9]{2}\.[A-Z0-9]$/', $matricule) === 1;
    }

    /**
     * Valider un matricule de personnel.
     * Format: PER.CMR.2024.CDI
     */
    public static function isValidStaffMatricule(string $matricule): bool
    {
        // Format: PER.{CODE}.{YEAR}.CDI
        return preg_match('/^PER\.[A-Z0-9]{1,10}\.(19|20)\d{2}\.CDI$/', $matricule) === 1;
    }

    /**
     * Déterminer le type d'utilisateur basé sur le matricule.
     */
    public static function getUserType(string $matricule): ?string
    {
        if (self::isValidStudentMatricule($matricule)) {
            return 'student';
        }

        if (self::isValidStaffMatricule($matricule)) {
            return 'staff_or_teacher';
        }

        return null;
    }

    /**
     * Extraire le programme d'études à partir du matricule étudiant.
     * GL.CMRY22.23.K => GL
     */
    public static function getStudentProgram(string $matricule): ?string
    {
        if (!self::isValidStudentMatricule($matricule)) {
            return null;
        }

        return str_before($matricule, '.');
    }

    /**
     * Extraire l'année d'inscription à partir du matricule étudiant.
     * GL.CMRY22.23.K => 23
     */
    public static function getStudentEnrollmentYear(string $matricule): ?string
    {
        if (!self::isValidStudentMatricule($matricule)) {
            return null;
        }

        // Récupérer le troisième segment: GL.CMRY22.23.K => 23
        $parts = explode('.', $matricule);
        return $parts[2] ?? null;
    }

    /**
     * Extraire l'année d'embauche à partir du matricule personnel.
     * PER.CMR.2024.CDI => 2024
     */
    public static function getStaffHireYear(string $matricule): ?string
    {
        if (!self::isValidStaffMatricule($matricule)) {
            return null;
        }

        // Récupérer le troisième segment: PER.CMR.2024.CDI => 2024
        $parts = explode('.', $matricule);
        return $parts[2] ?? null;
    }

    /**
     * Générer un regex pattern pour les validations Laravel.
     */
    public static function getStudentPattern(): string
    {
        return '/^(GL|SR)\.[A-Z0-9]+\.[0-9]{2}\.[A-Z0-9]$/';
    }

    public static function getStaffPattern(): string
    {
        return '/^PER\.[A-Z0-9]{1,10}\.(19|20)\d{2}\.CDI$/';
    }

    /**
     * Nettoyer/formater un matricule.
     */
    public static function sanitize(string $matricule): string
    {
        return strtoupper(trim($matricule));
    }
}
