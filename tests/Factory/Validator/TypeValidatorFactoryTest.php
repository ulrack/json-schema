<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Tests\Factory;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\JsonSchema\Factory\Validator\TypeValidatorFactory;

/**
 * @coversDefaultClass Ulrack\JsonSchema\Factory\Validator\TypeValidatorFactory
 */
class TypeValidatorFactoryTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::create
     * @covers ::createTypeValidator
     */
    public function testCreate(): void
    {
        $subject = new TypeValidatorFactory();

        $this->assertInstanceOf(
            ValidatorInterface::class,
            $subject->create('object')
        );

        $this->assertInstanceOf(
            ValidatorInterface::class,
            $subject->create(['object', 'boolean'])
        );

        $this->expectException(InvalidArgumentException::class);

        $subject->create('foo');
    }
}
