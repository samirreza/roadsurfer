<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;

final class RequestDTOParamConverter implements ParamConverterInterface
{
    public function __construct(
        private ValidatorInterface $validator,
        private SerializerInterface $serializer
    ) {
    }

    public function supports(ParamConverter $configuration)
    {
        if ($configuration->getClass() === null) {
            return false;
        }

        $reflection = new \ReflectionClass($configuration->getClass());
        if ($reflection->implementsInterface(RequestInterface::class)) {
            return true;
        }

        return false;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $constraints = $configuration->getClass()::getConstraints();
        $violations = $this->validator->validate(
            json_decode($request->getContent(), true),
            $constraints
        );
        if (count($violations) > 0) {
            throw new RequestDTOValidationException(
                $this->normalizeViolations($violations)
            );
        }

        $object = $this->serializer->deserialize(
            $request->getContent(),
            $configuration->getClass(),
            'json',
            ['disable_type_enforcement' => true]
        );

        $request->attributes->set($configuration->getName(), $object);
    }

    private function normalizeViolations(ConstraintViolationListInterface $constraintViolationList): array
    {
        $iterator = $constraintViolationList->getIterator();
        $errors = [];
        while ($iterator->valid()) {
            $violation = $iterator->current();
            $errors[$violation->getPropertyPath()] = $violation->getMessage();
            $iterator->next();
        }

        return $errors;
    }
}
