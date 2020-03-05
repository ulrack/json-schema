<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\JsonSchema\Common;

interface ReferenceResolutionInterface
{
    /**
     * Returns the schema.
     *
     * @return object|bool
     */
    public function getSchema();

    /**
     * Returns the identifier.
     *
     * @return string|null
     */
    public function getIdentifier(): ?string;
}
