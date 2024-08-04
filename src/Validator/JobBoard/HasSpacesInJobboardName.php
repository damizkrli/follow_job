<?php

namespace App\Validator\JobBoard;

use Symfony\Component\Validator\Constraint;

#[\Attribute] class HasSpacesInJobboardName extends Constraint
{
    public $message = '{{ value }} doit être séparé par un espace. Merci de modifier voter saisie.';
}