<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Tests\Factory;

use PHPUnit\Framework\TestCase;
use GrizzIt\Validator\Common\ValidatorInterface;
use Ulrack\JsonSchema\Common\ValidatorFactoryInterface;
use Ulrack\JsonSchema\Factory\Validator\ObjectValidatorFactory;

/**
 * @coversDefaultClass Ulrack\JsonSchema\Factory\Validator\ObjectValidatorFactory
 */
class ObjectValidatorFactoryTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::create
     */
    public function testCreate(): void
    {
        $validatorFactory = $this->createMock(ValidatorFactoryInterface::class);
        $validatorFactory->expects(static::any())
            ->method('create')
            ->willReturn($this->createMock(ValidatorInterface::class));

        $subject = new ObjectValidatorFactory($validatorFactory);

        $this->assertInstanceOf(
            ValidatorInterface::class,
            $subject->create(
                (object) [
                    'foo' => 'bar'
                ],
                (object) [
                    'bar' => 'baz'
                ],
                'qux',
                'test',
                (object) ['foo' => 'bar', 'bar' => ['foo']],
                ['bar'],
                1,
                2
            )
        );

        $this->assertInstanceOf(
            ValidatorInterface::class,
            $subject->create(
                null,
                null,
                null,
                null,
                null,
                null,
                null,
                null
            )
        );
    }
}
