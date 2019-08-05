<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Factory\Validator;

use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\Validator\Component\Chain\AndValidator;
use Ulrack\Validator\Component\Textual\MaxLengthValidator;
use Ulrack\Validator\Component\Textual\MinLengthValidator;
use Ulrack\Validator\Component\Textual\PatternValidator;

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
