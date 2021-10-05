<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class EntityExists extends Constraint
{
    public $message = 'Entity "%entity%" with property "%property%": "%value%" does not exist.';
    public $entityClassName;
    public $property = 'id';

    public function getRequiredOptions()
    {
        return [
            'entityClassName',
        ];
    }
}
