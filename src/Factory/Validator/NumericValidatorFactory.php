<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Factory\Validator;

use GrizzIt\Validator\Common\ValidatorInterface;
use GrizzIt\Validator\Component\Chain\AndValidator;
use GrizzIt\Validator\Component\Numeric\ExclusiveMaximumValidator;
use GrizzIt\Validator\Component\Numeric\ExclusiveMinimumValidator;
use GrizzIt\Validator\Component\Numeric\MaximumValidator;
use GrizzIt\Validator\Component\Numeric\MinimumValidator;
use GrizzIt\Validator\Component\Numeric\MultipleOfValidator;

class NumericValidatorFactory
{
    /**
     * Composes the numeric validator.
     *
     * @param float|null $minimum
     * @param float|null $maximum
     * @param float|null $exclusiveMinimum
     * @param float|null $exclusiveMaximum
     * @param float|null $multipleOf
     *
     * @return ValidatorInterface
     */
    public function create(
        ?float $minimum,
        ?float $maximum,
        ?float $exclusiveMinimum,
        ?float $exclusiveMaximum,
        ?float $multipleOf
    ): ValidatorInterface {
        $validators = [];

        if ($minimum !== null) {
            $validators[] = new MinimumValidator($minimum);
        }

        if ($maximum !== null) {
            $validators[] = new MaximumValidator($maximum);
        }

        if ($exclusiveMinimum !== null) {
            $validators[] = new ExclusiveMinimumValidator($exclusiveMinimum);
        }

        if ($exclusiveMaximum !== null) {
            $validators[] = new ExclusiveMaximumValidator($exclusiveMaximum);
        }

        if ($multipleOf !== null) {
            $validators[] = new MultipleOfValidator($multipleOf);
        }

        return new AndValidator(...$validators);
    }
}
