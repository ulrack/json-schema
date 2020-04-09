<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Tests\Factory;

use PHPUnit\Framework\TestCase;
use GrizzIt\Validator\Common\ValidatorInterface;
use Ulrack\JsonSchema\Common\ValidatorFactoryInterface;
use Ulrack\JsonSchema\Factory\Validator\LogicalValidatorFactory;

/**
 * @coversDefaultClass Ulrack\JsonSchema\Factory\Validator\LogicalValidatorFactory
 */
class LogicalValidatorFactoryTest extends TestCase
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

        $subject = new LogicalValidatorFactory($validatorFactory);

        $this->assertInstanceOf(
            ValidatorInterface::class,
            $subject->create(['foo'], false, false, false, true)
        );
    }
}
