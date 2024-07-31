<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class HasUniqueContact extends Constraint
{
    public string $message = 'Ce contact existe déjà en base de données. Veuillez modifier votre saisie.';
    public string $mode    = 'strict';

    public function __construct(?string $mode = null, ?string $message = null)
    {
        parent::__construct([]);

        $this->mode    = $mode ?? $this->mode;
        $this->message = $message ?? $this->message;
    }
}