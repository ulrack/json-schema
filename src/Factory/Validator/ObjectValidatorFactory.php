<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Factory\Validator;

use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\Validator\Component\Chain\AndValidator;
use Ulrack\JsonSchema\Common\AbstractValidatorFactory;
use Ulrack\Validator\Component\Object\RequiredValidator;
use Ulrack\Validator\Component\Object\DependencyValidator;
use Ulrack\Validator\Component\Object\PropertiesValidator;
use Ulrack\Validator\Component\Object\MaxPropertiesValidator;
use Ulrack\Validator\Component\Object\MinPropertiesValidator;

class ObjectValidatorFactory extends AbstractValidatorFactory
{
    /**
     * Composes the object validator.
     *
     * @param object|null $properties
     * @param object|null $patternProperties
     * @param mixed       $propertyNames
     * @param mixed       $additionalProperties
     * @param object|null $dependencies
     * @param array|null  $required
     * @param int|null    $minProperties
     * @param int|null    $maxProperties
     *
     * @return ValidatorInterface
     */
    public function create(
        ?object $properties,
        ?object $patternProperties,
        $propertyNames,
        $additionalProperties,
        ?object $dependencies,
        ?array $required,
        ?int $minProperties,
        ?int $maxProperties
    ): ValidatorInterface {
        $validators = [];
        $validatorFactory = $this->getValidatorFactory();

        if ($properties !== null
        || $additionalProperties !== null
        || $propertyNames !== null
        || $patternProperties !== null) {
            $validators[] = new PropertiesValidator(
                $properties === null
                    ? null
                    : array_map(
                        function ($item) use (
                            $validatorFactory
                        ): ValidatorInterface {
                            return $validatorFactory->create($item, false);
                        },
                        get_object_vars($properties)
                    ),
                $patternProperties === null
                    ? null
                    : array_map(
                        function ($item) use (
                            $validatorFactory
                        ): ValidatorInterface {
                            return $validatorFactory->create($item, false);
                        },
                        get_object_vars($patternProperties)
                    ),
                $propertyNames === null
                    ? null
                    : $validatorFactory->create($propertyNames, false),
                $additionalProperties === null
                    ? null
                    : $validatorFactory->create($additionalProperties, false)
            );
        }

        if ($dependencies !== null) {
            foreach (get_object_vars($dependencies) as $key => $dependency) {
                if (is_array($dependency)) {
                    $validators[] = new DependencyValidator(
                        $key,
                        new RequiredValidator(...$dependency)
                    );
                    continue;
                }

                $validators[] = new DependencyValidator(
                    $key,
                    $validatorFactory->create($dependency, false)
                );
            }
        }

        if ($required !== null) {
            $validators[] = new RequiredValidator(...$required);
        }

        if ($minProperties !== null) {
            $validators[] = new MinPropertiesValidator($minProperties);
        }

        if ($maxProperties !== null) {
            $validators[] = new MaxPropertiesValidator($maxProperties);
        }

        return new AndValidator(...$validators);
    }
}
