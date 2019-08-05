<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\JsonSchema\Common;

/**
 * An abstract implementation to tag a factory which requires the main
 * validator factory.
 */
abstract class AbstractValidatorFactory
{
    /** @var ValidatorFactoryInterface */
    private $validatorFactory;

    /**
     * Constructor.
     *
     * @param ValidatorFactoryInterface $validatorFactory
     */
    public function __construct(ValidatorFactoryInterface $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;
    }

    /**
     * Retrieve the validator factory.
     *
     * @return ValidatorFactoryInterface
     */
    public function getValidatorFactory(): ValidatorFactoryInterface
    {
        return $this->validatorFactory;
    }
}
