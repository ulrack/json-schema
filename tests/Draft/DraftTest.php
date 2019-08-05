<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Tests\Draft;

use PHPUnit\Framework\TestCase;
use Ulrack\JsonSchema\Common\SupportedDraftsEnum;
use Ulrack\JsonSchema\Factory\SchemaValidatorFactory;

class DraftTest extends TestCase
{
    /**
     * @param SupportedDraftsEnum $draft
     * @param object $schema
     * 
     * @return void
     * 
     * @dataProvider dataProvider
     */
    public function testDraft(
        SupportedDraftsEnum $draft, 
        object $schema
    ): void {
        $factory = new SchemaValidatorFactory($draft);
        $validator = $factory->createVerifiedValidator($schema);
        $this->assertEquals(true, $validator($schema));
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return [
            [
                SupportedDraftsEnum::DRAFT_07(),
                json_decode(
                    file_get_contents('http://json-schema.org/draft-07/schema#')
                ),
            ]
        ];
    }
}