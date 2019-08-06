<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Factory;

use InvalidArgumentException;
use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\JsonSchema\Exception\SchemaException;
use Ulrack\JsonSchema\Common\SupportedDraftsEnum;
use Ulrack\JsonSchema\Common\StorageManagerInterface;
use Ulrack\JsonSchema\Common\ValidatorFactoryInterface;
use Ulrack\JsonSchema\Component\Storage\StorageManager;
use Ulrack\JsonSchema\Factory\Validator\ValidatorFactory;
use Ulrack\JsonSchema\Common\SchemaValidatorFactoryInterface;

class SchemaValidatorFactory implements SchemaValidatorFactoryInterface
{
    /** @var StorageManagerInterface */
    private $storageManager;

    /** @var MapInterface */
    private $map;

    /** @var ValidatorFactoryInterface */
    private $validatorFactory;

    /**
     * Constructor
     *
     * @param SupportedDraftsEnum|null        $map
     * @param StorageManagerInterface|null    $storageManager
     * @param ReferenceResolverInterface|null $referenceResolver
     */
    public function __construct(
        SupportedDraftsEnum $map = null,
        StorageManagerInterface $storageManager = null,
        ValidatorFactoryInterface $validatorFactory = null
    ) {
        $map = !is_null($map)
            ? (string) $map
            : (string) SupportedDraftsEnum::DEFAULT();

        $this->map = new $map();
        $this->storageManager = $storageManager ?? new StorageManager();
        $this->validatorFactory = $validatorFactory ?? new ValidatorFactory(
            $this->map,
            $this->storageManager
        );
    }

    /**
     * Composes the schema validator.
     *
     * @param object|bool $schema
     *
     * @return ValidatorInterface
     */
    public function create($schema): ValidatorInterface
    {
        return $this->validatorFactory->create($schema);
    }

    /**
     * Creates a validator which is first verified against the defined $schema.
     *
     * @param object $schema
     *
     * @return ValidatorInterface
     *
     * @throws SchemaException When the $schema property isn't set.
     * @throws SchemaException When the schema itself is invalid.
     */
    public function createVerifiedValidator(object $schema): ValidatorInterface
    {
        if (!property_exists($schema, '$schema')) {
            throw new SchemaException(
                'The $schema property must be set for verified validators.'
            );
        }

        $validator = $this->createFromRemoteFile($schema->{'$schema'});
        if ($validator($schema)) {
            return $this->create($schema);
        }

        throw new SchemaException('The schema was invalid!');
    }

    /**
     * Creates the validator from a file path.
     *
     * @param string $path
     *
     * @return ValidatorInterface
     *
     * @throws InvalidArgumentException When the file can not be found.
     */
    public function createFromLocalFile(string $path): ValidatorInterface
    {
        $path = realpath($path);
        if (file_exists($path)) {
            return $this->createFromRemoteFile($path);
        }

        throw new InvalidArgumentException(
            sprintf(
                'Could not find file %s.',
                $path
            )
        );
    }

    /**
     * Creates the validator from a file path.
     *
     * @param string $path
     *
     * @return ValidatorInterface
     *
     * @throws InvalidArgumentException When the file can not be retrieved.
     */
    public function createFromRemoteFile(string $path): ValidatorInterface
    {
        $schemaStorage = $this->storageManager->getSchemaStorage();
        $validatorStorage = $this->storageManager->getValidatorStorage();
        if ($validatorStorage->has($path)) {
            return $validatorStorage->get($path);
        }

        if ($schemaStorage->has($path)) {
            $schema = $schemaStorage->get($path);

            $validatorStorage->set(
                $path,
                $this->create($schema)
            );

            return $validatorStorage->get($path);
        }

        return $this->createFromString(file_get_contents($path), $path);
    }

    /**
     * Creates a validator from a string.
     *
     * @param string      $json
     * @param string|null $id
     *
     * @return ValidatorInterface
     *
     * @throws SchemaException When the supplied JSON is invalid.
     */
    public function createFromString(
        string $json,
        string $id = null
    ): ValidatorInterface {
        $schema = json_decode($json);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new SchemaException(
                sprintf(
                    'Could not prepare schema, invalid JSON supplied: %s.',
                    json_last_error_msg()
                )
            );
        }

        if (is_object($schema)
        && !property_exists($schema, '$id')
        && $id !== null) {
            $schema->{'$id'} = $id;
        }

        $this->storageManager
            ->getSchemaStorage()
            ->set($schema->{'$id'}, $schema);

        $validator = $this->create($schema);

        $this->storageManager
            ->getValidatorStorage()
            ->set($schema->{'$id'}, $validator);

        return $validator;
    }
}
