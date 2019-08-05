<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Factory;

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
     */
    public function createFromLocalFile(string $path): ValidatorInterface
    {
        $path = realpath($path);
        if (file_exists($path)) {
            return $this->createFromRemoteFile($path);
        }
    }

    /**
     * Creates the validator from a file path.
     *
     * @param string $path
     *
     * @return ValidatorInterface
     */
    public function createFromRemoteFile(string $path): ValidatorInterface
    {
        $schemaStorage = $this->storageManager->getSchemaStorage();
        $validatorStorage = $this->storageManager->getValidatorStorage();
        if ($schemaStorage->has($path)) {
            if ($validatorStorage->has($path)) {
                return $validatorStorage->get($path);
            }

            return $this->create($schemaStorage->get($path));
        }

        $aliasStorage = $this->storageManager->getAliasStorage();
        if ($aliasStorage->has($path)) {
            $alias = $aliasStorage->get($path);
            if ($schemaStorage->has($alias)) {
                if ($validatorStorage->has($alias)) {
                    return $validatorStorage->get($alias);
                }

                return $this->create(
                    $schemaStorage->get($alias)
                );
            }
        }

        $file = file_get_contents($path);
        if ($file !== false) {
            return $this->createFromString($file, $path);
        }
    }

    /**
     * Creates a validator from a string.
     *
     * @param string $json
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

        if (property_exists($schema, '$id') && $id !== null) {
            $this->storageManager
                ->getAliasStorage()
                ->set($id, $schema->{'$id'});
        } elseif (!property_exists($schema, '$id') && $id !== null) {
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
