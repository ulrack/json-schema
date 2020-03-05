<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Tests\Component\Resolver;

use PHPUnit\Framework\TestCase;
use Ulrack\JsonSchema\Exception\SchemaException;
use Ulrack\JsonSchema\Component\Storage\StorageManager;
use Ulrack\JsonSchema\Component\Resolver\ReferenceResolver;
use Ulrack\JsonSchema\Component\Resolver\ReferenceResolution;
use Ulrack\JsonSchema\Component\Validator\ReferenceValidator;

/**
 * @coversDefaultClass Ulrack\JsonSchema\Component\Resolver\ReferenceResolver
 * @covers Ulrack\JsonSchema\Component\Resolver\ReferenceResolution
 * @covers Ulrack\JsonSchema\Component\Storage\StorageManager
 */
class ReferenceResolverTest extends TestCase
{
    /**
     * @param StorageManager           $storageManager
     * @param ReferenceValidator       $reference
     * @param ReferenceResolution|null $expected
     *
     * @return void
     *
     * @covers ::__construct
     * @covers ::resolve
     *
     * @dataProvider referenceProvider
     */
    public function testResolver(
        StorageManager $storageManager,
        ReferenceValidator $reference,
        $expected
    ): void {
        $subject = new ReferenceResolver($storageManager);
        $this->assertEquals(
            $expected,
            $subject->resolve($reference)
        );
    }

    /**
     * @param ReferenceValidator $reference
     *
     * @return void
     *
     * @covers ::__construct
     * @covers ::resolve
     *
     * @dataProvider failureProvider
     */
    public function testResolverException(ReferenceValidator $reference): void
    {
        $subject = new ReferenceResolver(new StorageManager());

        $this->expectException(SchemaException::class);

        $subject->resolve($reference);
    }

    /**
     * @return array
     */
    public function failureProvider(): array
    {
        return [
            [
                $this->createReferenceValidator(
                    [
                        'isResolved' => false,
                        'getReference' => 'http://json-schema.org/draft-07/schema'.
                        '#/definitions/nonNegativeIntegerDefault0/allOf/2'
                    ]
                )
            ],
            [
                $this->createReferenceValidator(
                    [
                        'isResolved' => false,
                        'getReference' => 'http://json-schema.org/draft-07/schema'.
                        '#/definitions/nonNegativeIntegerDefault0/noneOf'
                    ]
                )
            ]
        ];
    }

    /**
     * @return array
     */
    public function referenceProvider(): array
    {
        return [
            [
                $this->createMock(StorageManager::class),
                $this->createReferenceValidator(
                    [
                        'isResolved' => true
                    ]
                ),
                null
            ],
            [
                new StorageManager(),
                $this->createReferenceValidator(
                    [
                        'isResolved' => false,
                        'getReference' => 'http://json-schema.org/draft-07/sc'.
                        'hema#/definitions/nonNegativeIntegerDefault0/allOf/1'
                    ]
                ),
                new ReferenceResolution(
                    (object) ['default' => 0],
                    'http://json-schema.org/draft-07/schema'
                )
            ]
        ];
    }

    /**
     * Creates a configured ReferenceValidator.
     *
     * @param array $methodConfiguration
     *
     * @return ReferenceValidator
     */
    private function createReferenceValidator(
        array $methodConfiguration
    ): ReferenceValidator {
        $reference = $this->createMock(ReferenceValidator::class);

        foreach ($methodConfiguration as $method => $return) {
            $reference->expects(static::once())
                ->method($method)
                ->willReturn($return);
        }

        return $reference;
    }
}
