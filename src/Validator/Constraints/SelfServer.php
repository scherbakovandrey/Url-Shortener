<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class SelfServer extends Constraint
{
    public $message = 'This url is already shorten';
}