<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Component\Storage;

use Ulrack\Storage\Common\StorageInterface;
use Ulrack\Storage\Component\ObjectStorage;
use Ulrack\JsonSchema\Common\StorageManagerInterface;

class StorageManager implements StorageManagerInterface
{
    /**
     * Contains the schema storage.
     *
     * @var StorageInterface
     */
    private $schemaStorage;

    /**
     * Contains the alias storage.
     *
     * @var StorageInterface
     */
    private $aliasStorage;

    /**
     * Contains the validator storage.
     *
     * @var StorageInterface
     */
    private $validatorStorage;

    /**
     * Contains the reference storage.
     *
     * @var StorageInterface
     */
    private $referenceStorage;

    /**
     * Constructor
     *
     * @param StorageInterface $schemaStorage
     * @param StorageInterface $aliasStorage
     * @param StorageInterface $validatorStorage
     * @param StorageInterface $referenceStorage
     */
    public function __construct(
        StorageInterface $schemaStorage = null,
        StorageInterface $aliasStorage = null,
        StorageInterface $validatorStorage = null,
        StorageInterface $referenceStorage = null
    ) {
        $this->schemaStorage = $schemaStorage ?? new ObjectStorage();
        $this->aliasStorage = $aliasStorage ?? new ObjectStorage();
        $this->validatorStorage = $validatorStorage ?? new ObjectStorage();
        $this->referenceStorage = $referenceStorage ?? new ObjectStorage();
    }

    /**
     * Retrieves the schema storage.
     *
     * @return StorageInterface
     */
    public function getSchemaStorage(): StorageInterface
    {
        return $this->schemaStorage;
    }

    /**
     * Retrieves the alias storage.
     *
     * @return StorageInterface
     */
    public function getAliasStorage(): StorageInterface
    {
        return $this->aliasStorage;
    }

    /**
     * Retrieves the validator storage.
     *
     * @return StorageInterface
     */
    public function getValidatorStorage(): StorageInterface
    {
        return $this->validatorStorage;
    }

    /**
     * Retrieves the reference storage.
     *
     * @return StorageInterface
     */
    public function getReferenceStorage(): StorageInterface
    {
        return $this->referenceStorage;
    }
}
