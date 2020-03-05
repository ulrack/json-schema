<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\JsonSchema\Component\Resolver;

use Ulrack\JsonSchema\Common\ReferenceResolutionInterface;

class ReferenceResolution implements ReferenceResolutionInterface
{
    /** @var object|bool */
    private $schema;

    /** @var string|null */
    private $identifier;

    /**
     * Constructor.
     *
     * @param object|bool $schema
     * @param string|null $identifier
     */
    public function __construct($schema, ?string $identifier)
    {
        $this->schema = $schema;
        $this->identifier = $identifier;
    }

    /**
     * Returns the schema.
     *
     * @return object|bool
     */
    public function getSchema()
    {
        return $this->schema;
    }

    /**
     * Returns the identifier.
     *
     * @return string|null
     */
    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }
}
