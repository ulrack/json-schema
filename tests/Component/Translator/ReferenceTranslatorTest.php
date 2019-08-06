<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Tests\Component\Translator;

use PHPUnit\Framework\TestCase;
use Ulrack\JsonSchema\Exception\SchemaException;
use Ulrack\JsonSchema\Component\Translator\ReferenceTranslator;

/**
 * @coversDefaultClass Ulrack\JsonSchema\Component\Translator\ReferenceTranslator
 * @covers Ulrack\JsonSchema\Exception\SchemaException
 */
class ReferenceTranslatorTest extends TestCase
{
    /**
     * @param string $schemaId,
     * @param string $reference
     * @param string $expected
     *
     * @return void
     *
     * @covers ::translate
     *
     * @dataProvider translatorProvider
     */
    public function testTranslate(
        string $schemaId,
        string $reference,
        string $expected
    ): void {
        $subject = new ReferenceTranslator();

        $this->assertEquals(
            $expected,
            $subject->translate($schemaId, $reference)
        );
    }

    /**
     * @return void
     *
     * @covers ::translate
     */
    public function testTranslateException(): void
    {
        $subject = new ReferenceTranslator();
        $this->expectException(SchemaException::class);
        $subject->translate('/test/', '/foo/');
    }

    /**
     * @return string[][]
     */
    public function translatorProvider(): array
    {
        return [
            [
                'http://json-schema.org/draft-07/schema#',
                '#/definitions/schemaArray',
                'http://json-schema.org/draft-07/schema#/definitions/schemaArray'
            ],
            [
                '#',
                'http://json-schema.org/draft-07/schema#',
                'http://json-schema.org/draft-07/schema#'
            ],
            [
                'http://json-schema.org/draft-07/schema#/definitions/nonNegativeInteger',
                '/defintions/schemaArray',
                'http://json-schema.org/draft-07/schema#/defintions/schemaArray'
            ],
            [
                'http://json-schema.org/draft-07/schema/definitions/nonNegativeInteger',
                '/definitions/schemaArray',
                'http://json-schema.org/definitions/schemaArray'
            ],
        ];
    }
}
