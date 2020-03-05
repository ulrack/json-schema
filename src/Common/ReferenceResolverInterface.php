<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */
namespace Ulrack\JsonSchema\Common;

use Ulrack\JsonSchema\Component\Validator\ReferenceValidator;

interface ReferenceResolverInterface
{
    /**
     * Resolves the references.
     *
     * @param ReferenceValidator $reference
     *
     * @return ReferenceResolutionInterface|null
     */
    public function resolve(
        ReferenceValidator $reference
    ): ?ReferenceResolutionInterface;
}
