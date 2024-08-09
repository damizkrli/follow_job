<?php

namespace App\Validator\Application;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class HasUniqueApplication extends Constraint
{
    public string $message = 'Vous avez déjà postulé à cette annonce.';
}
