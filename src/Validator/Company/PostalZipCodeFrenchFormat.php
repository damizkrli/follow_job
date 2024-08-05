<?php

namespace App\Validator\Company;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class PostalZipCodeFrenchFormat extends Constraint
{
    public string $message = 'Veuillez saisir les 5 chiffres de voter code postal.';
}
