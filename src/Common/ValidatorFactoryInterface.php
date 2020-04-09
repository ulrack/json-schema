<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\JsonSchema\Common;

use GrizzIt\Validator\Common\ValidatorInterface;

interface ValidatorFactoryInterface
{
    /**
     * Composes the schema validator.
     *
     * @param object|bool $schema
     * @param bool        $isBase
     * @param string|null $overrideId
     *
     * @return ValidatorInterface
     */
    public function create(
        $schema,
        bool $isBase = true,
        string $overrideId = null
    ): ValidatorInterface;
}
