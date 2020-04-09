<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Component\Validator;

use GrizzIt\Validator\Common\ValidatorInterface;

class ReferenceValidator implements ValidatorInterface
{
    /**
     * Contains the validator.
     *
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * Contains the reference to the other schema.
     *
     * @var string
     */
    private $reference;

    /**
     * Constructor.
     *
     * @param string $validator
     */
    public function __construct(string $reference)
    {
        $this->reference = $reference;
    }

    /**
     * Set the validator.
     *
     * @param ValidatorInterface $validator
     *
     * @return void
     */
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    /**
     * Get the reference to the other schema.
     *
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * Determines if the reference is resolved.
     *
     * @return bool
     */
    public function isResolved(): bool
    {
        return $this->validator !== null;
    }

    /**
     * Validate the data against the validator.
     *
     * @param mixed $data
     *
     * @return bool
     */
    public function __invoke($data): bool
    {
        return $this->validator->__invoke($data);
    }
}
