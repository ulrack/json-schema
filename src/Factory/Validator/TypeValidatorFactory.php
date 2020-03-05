<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Factory\Validator;

use InvalidArgumentException;
use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\Validator\Component\Chain\OrValidator;
use Ulrack\Validator\Component\Type\ArrayValidator;
use Ulrack\Validator\Component\Type\BooleanValidator;
use Ulrack\Validator\Component\Type\IntegerValidator;
use Ulrack\Validator\Component\Type\NullValidator;
use Ulrack\Validator\Component\Type\NumberValidator;
use Ulrack\Validator\Component\Type\ObjectValidator;
use Ulrack\Validator\Component\Type\StringValidator;

class TypeValidatorFactory
{
    /**
     * Contains the type map to convert a type to a validator class.
     *
     * @var string[]
     */
    private $typeMap;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->typeMap = [
            'array'   => ArrayValidator::class,
            'boolean' => BooleanValidator::class,
            'integer' => IntegerValidator::class,
            'null'    => NullValidator::class,
            'number'  => NumberValidator::class,
            'object'  => ObjectValidator::class,
            'string'  => StringValidator::class,
        ];
    }

    /**
     * Composes the type validator.
     *
     * @param string|array $types
     *
     * @return ValidatorInterface
     */
    public function create($types): ValidatorInterface
    {
        if (is_array($types)) {
            $validators = [];
            foreach ($types as $type) {
                $validators[] = $this->createTypeValidator($type);
            }

            return new OrValidator(...$validators);
        }

        return $this->createTypeValidator($types);
    }

    /**
     * Creates a single instance of a type validator.
     *
     * @param  string $type
     *
     * @return ValidatorInterface
     */
    private function createTypeValidator(string $type): ValidatorInterface
    {
        if (!isset($this->typeMap[$type])) {
            throw new InvalidArgumentException(
                sprintf(
                    'Type %s is not a valid type.',
                    $type
                )
            );
        }

        return new $this->typeMap[$type]();
    }
}
