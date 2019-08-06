<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Component\Translator;

use Ulrack\JsonSchema\Exception\SchemaException;
use Ulrack\JsonSchema\Common\ReferenceTranslatorInterface;

class ReferenceTranslator implements ReferenceTranslatorInterface
{
    const URL_REGEX = '/^(https?:\\/\\/){1}(((?!-)[0-9a-z-]+[0-9a-z]+(?!-))(' .
    '\\.(?!-)[0-9a-z-]+[0-9a-z]+(?!-))*(:\\d+)?)([\\w\\/\\-]*#?)/';

    /**
     * Translates the reference.
     *
     * @param string $schemaId
     * @param string $reference
     *
     * @return string
     *
     * @throws SchemaException When the reference can not be determined.
     */
    public function translate(string $schemaId, string $reference): string
    {
        if (substr($reference, 0, 1) === '#') {
            return rtrim($schemaId, '#') . $reference;
        }

        if (preg_match('/^https?:\/\//', $reference) === 1) {
            return $reference;
        }

        if (preg_match(static::URL_REGEX, $schemaId, $matches) === 1) {
            if (strpos($matches[6], '#') === false) {
                return sprintf('%s%s/%s', $matches[1], $matches[2], ltrim($reference, '/'));
            }

            return sprintf('%s/%s', $matches[0], ltrim($reference, '/'));
        }

        throw new SchemaException(
            sprintf(
                'Could not translate %s in %s.',
                $reference,
                $schemaId
            )
        );
    }
}
