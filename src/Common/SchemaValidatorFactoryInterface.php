<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\JsonSchema\Common;

use Ulrack\Validator\Common\ValidatorInterface;

interface SchemaValidatorFactoryInterface
{
    /**
     * Composes the schema validator.
     *
     * @param object|bool $schema
     *
     * @return ValidatorInterface
     */
    public function create($schema): ValidatorInterface;

    /**
     * Creates the validator from a file path.
     *
     * @param string $path
     *
     * @return ValidatorInterface
     */
    public function createFromLocalFile(string $path): ValidatorInterface;

    /**
     * Creates the validator from a file path.
     *
     * @param string $path
     *
     * @return ValidatorInterface
     */
    public function createFromRemoteFile(string $path): ValidatorInterface;

    /**
     * Creates a validator from a string.
     *
     * @param string $json
     *
     * @return ValidatorInterface
     */
    public function createFromString(
        string $json,
        string $id = null
    ): ValidatorInterface;
}
