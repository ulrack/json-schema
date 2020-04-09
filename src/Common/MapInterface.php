<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\JsonSchema\Common;

use GrizzIt\Storage\Common\StorageInterface;
use GrizzIt\Validator\Common\ValidatorInterface;

interface MapInterface extends StorageInterface
{
    /**
     * Additional schema factory option.
     *
     * @param object|bool $schema
     *
     * @return ValidatorInterface|null
     */
    public function create($schema): ?ValidatorInterface;
}
