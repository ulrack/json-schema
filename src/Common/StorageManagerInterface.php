<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\JsonSchema\Common;

use Ulrack\Storage\Common\StorageInterface;

interface StorageManagerInterface
{
    /**
     * Retrieves the schema storage.
     *
     * @return StorageInterface
     */
    public function getSchemaStorage(): StorageInterface;

    /**
     * Retrieves the validator storage.
     *
     * @return StorageInterface
     */
    public function getValidatorStorage(): StorageInterface;

    /**
     * Retrieves the reference storage.
     *
     * @return StorageInterface
     */
    public function getReferenceStorage(): StorageInterface;
}
