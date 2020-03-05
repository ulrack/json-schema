<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\JsonSchema\Common\ValidatorFactoryInterface;
use Ulrack\JsonSchema\Factory\Validator\IterableValidatorFactory;

/**
 * @coversDefaultClass Ulrack\JsonSchema\Factory\Validator\IterableValidatorFactory
 */
class IterableValidatorFactoryTest extends TestCase
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

        $subject = new IterableValidatorFactory($validatorFactory);

        $this->assertInstanceOf(
            ValidatorInterface::class,
            $subject->create(['foo'], ['bar'], ['baz'], 1, 2, false)
        );
    }
}
