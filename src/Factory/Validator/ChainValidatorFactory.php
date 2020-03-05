<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Factory\Validator;

use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\Validator\Component\Chain\OrValidator;
use Ulrack\Validator\Component\Chain\AndValidator;
use Ulrack\Validator\Component\Chain\OneOfValidator;
use Ulrack\JsonSchema\Common\AbstractValidatorFactory;

class ChainValidatorFactory extends AbstractValidatorFactory
{
    /**
     * Composes the chain validator.
     *
     * @param array|null $oneOf
     * @param array|null $anyOf
     * @param array|null $allOf
     *
     * @return ValidatorInterface
     */
    public function create(
        ?array $oneOf,
        ?array $anyOf,
        ?array $allOf
    ): ValidatorInterface {
        $validators = [];
        $validatorFactory = $this->getValidatorFactory();

        if ($oneOf !== null) {
            $validators[] = new OneOfValidator(
                ...array_map(
                    function ($item) use (
                        $validatorFactory
                    ): ValidatorInterface {
                        return $validatorFactory->create($item, false);
                    },
                    $oneOf
                )
            );
        }

        if ($anyOf !== null) {
            $validators[] = new OrValidator(
                ...array_map(
                    function ($item) use (
                        $validatorFactory
                    ): ValidatorInterface {
                        return $validatorFactory->create($item, false);
                    },
                    $anyOf
                )
            );
        }

        if ($allOf !== null) {
            $validators[] = new AndValidator(
                ...array_map(
                    function ($item) use (
                        $validatorFactory
                    ): ValidatorInterface {
                        return $validatorFactory->create($item, false);
                    },
                    $allOf
                )
            );
        }

        return new AndValidator(...$validators);
    }
}
