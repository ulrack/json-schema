<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\JsonSchema\Factory\Validator\TextualValidatorFactory;

/**
 * @coversDefaultClass Ulrack\JsonSchema\Factory\Validator\TextualValidatorFactory
 */
class TextualValidatorFactoryTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::create
     */
    public function testCreate(): void
    {
        $subject = new TextualValidatorFactory();

        $this->assertInstanceOf(
            ValidatorInterface::class,
            $subject->create(
                1,
                2,
                'foo'
            )
        );
    }
}
