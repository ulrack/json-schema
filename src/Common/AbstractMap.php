<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\JsonSchema\Common;

use LogicException;
use Ulrack\JsonSchema\Common\MapInterface;
use GrizzIt\Storage\Component\ObjectStorage;
use Ulrack\JsonSchema\Exception\SchemaException;
use Ulrack\JsonSchema\Common\AbstractValidatorFactory;

abstract class AbstractMap extends ObjectStorage implements MapInterface
{
    /**
     * Contains the instantiated factories.
     *
     * @var AbstractValidatorFactory
     */
    private $factories;

    /**
     * Retrieves an instance of the requested factory.
     *
     * @param ValidatorFactoryInterface $validator
     * @param string $factory
     *
     * @return AbstractValidatorFactory
     *
     * @throws SchemaException When the factory is unknown to the map.
     */
    public function getFactory(
        ValidatorFactoryInterface $validator,
        string $factory
    ) {
        if ($this->has($factory)) {
            if (!isset($this->factories[$factory])) {
                if (is_a($factory, AbstractValidatorFactory::class, true)) {
                    $this->factories[$factory] = new $factory($validator);

                    return $this->factories[$factory];
                }

                $this->factories[$factory] = new $factory();
            }

            return $this->factories[$factory];
        }

        throw new SchemaException(
            sprintf(
                'Could not instantiate factory: "%s" from map.',
                $factory
            )
        );
    }

    /**
     * Sets data on a specific key within the storage.
     *
     * @param string|int $key
     * @param mixed  $data
     *
     * @return void
     *
     * @throws LogicException When the method is invoked.
     */
    public function set($key, $data): void
    {
        throw new LogicException('Non permitted operation.');
    }

    /**
     * Removes data from a key within a storage.
     *
     * @param string|int $key
     *
     * @return void
     *
     * @throws LogicException When the method is invoked.
     */
    public function unset($key): void
    {
        throw new LogicException('Non permitted operation.');
    }
}
