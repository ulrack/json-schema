<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Factory\Validator;

use GrizzIt\Validator\Common\ValidatorInterface;
use GrizzIt\Validator\Component\Chain\AndValidator;
use GrizzIt\Validator\Component\Logical\NotValidator;
use GrizzIt\Validator\Component\Logical\EnumValidator;
use Ulrack\JsonSchema\Common\AbstractValidatorFactory;
use GrizzIt\Validator\Component\Logical\IfThenElseValidator;

class LogicalValidatorFactory extends AbstractValidatorFactory
{
    /**
     * Composes the logical validator.
     *
     * @param array|null       $enum
     * @param object|bool|null $if
     * @param object|bool|null $then
     * @param object|bool|null $else
     * @param object|bool|null $not
     *
     * @return ValidatorInterface
     */
    public function create(
        ?array $enum,
        $if,
        $then,
        $else,
        $not
    ): ValidatorInterface {
        $validators = [];
        $validatorFactory = $this->getValidatorFactory();

        if ($enum !== null) {
            $validators[] = new EnumValidator($enum);
        }

        if ($if !== null) {
            $validators[] = new IfThenElseValidator(
                $validatorFactory->create($if, false),
                $then !== null ? $validatorFactory->create($then, false)
                    : null,
                $else !== null ? $validatorFactory->create($else, false)
                    : null
            );
        }

        if ($not !== null) {
            $validators[] = new NotValidator(
                $validatorFactory->create($not, false)
            );
        }

        return new AndValidator(...$validators);
    }
}
