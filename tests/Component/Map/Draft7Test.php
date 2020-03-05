<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Tests\Component\Map;

use LogicException;
use PHPUnit\Framework\TestCase;
use Ulrack\JsonSchema\Component\Map\Draft7;
use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\JsonSchema\Exception\SchemaException;
use Ulrack\JsonSchema\Common\ValidatorFactoryInterface;
use Ulrack\JsonSchema\Factory\Validator\TypeValidatorFactory;
use Ulrack\JsonSchema\Factory\Validator\ChainValidatorFactory;

/**
 * @coversDefaultClass Ulrack\JsonSchema\Component\Map\Draft7
 * @covers Ulrack\JsonSchema\Common\AbstractMap
 */
class Draft7Test extends TestCase
{
    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::create
     */
    public function testCreate(): void
    {
        $subject = new Draft7();

        $this->assertEquals(
            null,
            $subject->create((object)['foo' => 'bar'])
        );

        $this->assertInstanceOf(
            ValidatorInterface::class,
            $subject->create((object)['const' => 'foo'])
        );
    }

    /**
     * @return void
     */
    public function testAbstractMapSet(): void
    {
        $subject = new Draft7();
        $this->expectException(LogicException::class);
        $subject->set('foo', 'bar');
    }

    /**
     * @return void
     */
    public function testAbstractMapUnset(): void
    {
        $subject = new Draft7();
        $this->expectException(LogicException::class);
        $subject->unset('foo');
    }

    /**
     * @return void
     */
    public function testAbstractMapGetFactoryException(): void
    {
        $subject = new Draft7();
        $this->expectException(SchemaException::class);
        $subject->getFactory(
            $this->createMock(ValidatorFactoryInterface::class),
            ValidatorInterface::class
        );
    }

    /**
     * @return void
     */
    public function testAbstractMapGetFactory(): void
    {
        $subject = new Draft7();

        $this->assertInstanceOf(
            ChainValidatorFactory::class,
            $subject->getFactory(
                $this->createMock(ValidatorFactoryInterface::class),
                ChainValidatorFactory::class
            )
        );

        $this->assertInstanceOf(
            TypeValidatorFactory::class,
            $subject->getFactory(
                $this->createMock(ValidatorFactoryInterface::class),
                TypeValidatorFactory::class
            )
        );
    }
}
