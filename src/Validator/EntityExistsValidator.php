<?php

namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class EntityExistsValidator extends ConstraintValidator
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof EntityExists) {
            throw new UnexpectedTypeException($constraint, EntityExists::class);
        }

        if ($value === null || $value === '') {
            return;
        }

        if ($this->entityManager->getMetadataFactory()->isTransient($constraint->entityClassName)) {
            throw new \Exception("{$constraint->entityClassName} is not entity.");
        }

        $entity = $this->entityManager
            ->getRepository($constraint->entityClassName)
            ->findOneBy([$constraint->property => $value]);

        if ($entity === null) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('%entity%', $constraint->entityClassName)
                ->setParameter('%property%', $constraint->property)
                ->setParameter('%value%', (string) $value)
                ->addViolation();
        }
    }
}
