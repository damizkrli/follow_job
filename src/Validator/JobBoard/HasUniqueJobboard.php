<?php

namespace App\Validator\JobBoard;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class HasUniqueJobboard extends Constraint
{
    public $message = '{{ value }} existe déjà en base de données. Veuillez enregistrer un nouveau Jobboard.';
}