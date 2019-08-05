<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Component\Map;

use Ulrack\JsonSchema\Common\AbstractMap;
use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\Validator\Component\Logical\ConstValidator;
use Ulrack\JsonSchema\Factory\Validator\TypeValidatorFactory;
use Ulrack\JsonSchema\Factory\Validator\ChainValidatorFactory;
use Ulrack\JsonSchema\Factory\Validator\ObjectValidatorFactory;
use Ulrack\JsonSchema\Factory\Validator\LogicalValidatorFactory;
use Ulrack\JsonSchema\Factory\Validator\NumericValidatorFactory;
use Ulrack\JsonSchema\Factory\Validator\TextualValidatorFactory;
use Ulrack\JsonSchema\Factory\Validator\IterableValidatorFactory;

class Draft7 extends AbstractMap
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct(
            [
                IterableValidatorFactory::class => [
                    'items',
                    'additionalItems',
                    'contains',
                    'minItems',
                    'maxItems',
                    'uniqueItems'
                ],
                NumericValidatorFactory::class => [
                    'minimum',
                    'maximum',
                    'exclusiveMinimum',
                    'exclusiveMaximum',
                    'multipleOf'
                ],
                ObjectValidatorFactory::class => [
                    'properties',
                    'patternProperties',
                    'propertyNames',
                    'additionalProperties',
                    'dependencies',
                    'required',
                    'minProperties',
                    'maxProperties'
                ],
                TypeValidatorFactory::class => ['type'],
                LogicalValidatorFactory::class => [
                    'enum',
                    'if',
                    'then',
                    'else',
                    'not'
                ],
                TextualValidatorFactory::class => [
                    'minLength',
                    'maxLength',
                    'pattern'
                ],
                ChainValidatorFactory::class => [
                    'oneOf',
                    'anyOf',
                    'allOf'
                ]
            ]
        );
    }

    /**
     * Additional schema factory option.
     *
     * @param object|bool $schema
     *
     * @return ValidatorInterface|null
     */
    public function create($schema): ?ValidatorInterface
    {
        if (is_object($schema) && property_exists($schema, 'const')) {
            return new ConstValidator($schema->const);
        }

        return null;
    }
}
