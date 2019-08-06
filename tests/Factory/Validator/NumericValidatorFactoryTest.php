<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Tests\Factory;

use PHPUnit\Framework\TestCase;
use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\JsonSchema\Factory\Validator\NumericValidatorFactory;

/**
 * @coversDefaultClass Ulrack\JsonSchema\Factory\Validator\NumericValidatorFactory
 */
class NumericValidatorFactoryTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::create
     */
    public function testCreate(): void
    {
        $subject = new NumericValidatorFactory();

        $this->assertInstanceOf(
            ValidatorInterface::class,
            $subject->create(1, 2, 3, 4, 5)
        );
    }
}
