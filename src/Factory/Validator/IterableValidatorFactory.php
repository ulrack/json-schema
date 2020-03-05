<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Factory\Validator;

use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\Validator\Component\Chain\AndValidator;
use Ulrack\JsonSchema\Common\AbstractValidatorFactory;
use Ulrack\Validator\Component\Iterable\ItemsValidator;
use Ulrack\Validator\Component\Logical\AlwaysValidator;
use Ulrack\Validator\Component\Iterable\ContainsValidator;
use Ulrack\Validator\Component\Iterable\MaxItemsValidator;
use Ulrack\Validator\Component\Iterable\MinItemsValidator;
use Ulrack\Validator\Component\Iterable\UniqueItemsValidator;

class IterableValidatorFactory extends AbstractValidatorFactory
{
    /**
     * Composes the iterable validator.
     *
     * @param mixed     $items
     * @param mixed     $additionalItems
     * @param mixed     $contains
     * @param int|null  $minItems
     * @param int|null  $maxItems
     * @param bool|null $uniqueItems
     *
     * @return ValidatorInterface
     */
    public function create(
        $items,
        $additionalItems,
        $contains,
        ?int $minItems,
        ?int $maxItems,
        ?bool $uniqueItems
    ): ValidatorInterface {
        $validators = [];
        $validatorFactory = $this->getValidatorFactory();

        if ($items !== null || $additionalItems !== null) {
            $validators[] = new ItemsValidator(
                $items === null ? null : (
                    is_array($items)
                        ? array_map(
                            function ($item) use (
                                $validatorFactory
                            ): ValidatorInterface {
                                return $validatorFactory->create($item, false);
                            },
                            $items
                        ) : $validatorFactory->create($items, false)
                ),
                $additionalItems === null
                    ? new AlwaysValidator(true)
                    : $validatorFactory->create($additionalItems, false)
            );
        }

        if ($contains !== null) {
            $validators[] = new ContainsValidator(
                $validatorFactory->create($contains, false)
            );
        }

        if ($minItems !== null) {
            $validators[] = new MinItemsValidator($minItems);
        }

        if ($maxItems !== null) {
            $validators[] = new MaxItemsValidator($maxItems);
        }

        if ($uniqueItems !== null) {
            $validators[] = new UniqueItemsValidator($uniqueItems);
        }

        return new AndValidator(...$validators);
    }
}
