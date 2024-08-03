<?php

namespace App\Validator\Contact;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class HasPhoneNumberHasNineDigits extends Constraint
{
    public string $message = 'Veuillez saisir les 10 chiffres du numéro de téléphone du contact.';
}