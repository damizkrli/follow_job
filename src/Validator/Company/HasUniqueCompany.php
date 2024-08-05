<?php

namespace App\Validator\Company;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class HasUniqueCompany extends Constraint
{
    public string $message = '"{{ value }}" existe déjà en base de données. Veuillez enregistrer une nouvelle entreprise.';
}
