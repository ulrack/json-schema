<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Factory\Validator;

use GrizzIt\Validator\Common\ValidatorInterface;
use GrizzIt\Validator\Component\Chain\AndValidator;
use GrizzIt\Validator\Component\Textual\MaxLengthValidator;
use GrizzIt\Validator\Component\Textual\MinLengthValidator;
use GrizzIt\Validator\Component\Textual\PatternValidator;

class TextualValidatorFactory
{
    /**
     * Composes the textual validator.
     *
     * @param int|null    $minLength
     * @param int|null    $maxLength
     * @param string|null $pattern
     *
     * @return ValidatorInterface
     */
    public function create(
        ?int $minLength,
        ?int $maxLength,
        ?string $pattern
    ): ValidatorInterface {
        $validators = [];

        if ($minLength !== null) {
            $validators[] = new MinLengthValidator($minLength);
        }

        if ($maxLength !== null) {
            $validators[] = new MaxLengthValidator($maxLength);
        }

        if ($pattern !== null) {
            $validators[] = new PatternValidator($pattern);
        }

        return new AndValidator(...$validators);
    }
}
