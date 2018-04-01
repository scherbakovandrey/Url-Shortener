<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SelfServerValidator extends ConstraintValidator
{
    private $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function validate($value, Constraint $constraint)
    {
        //We want to be sure we don't accept the same server urls
        $serverBaseUrl = $this->router->generate('home', [], UrlGeneratorInterface::ABSOLUTE_URL);
        if (strpos($value, $serverBaseUrl) !== false) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }
    }
}