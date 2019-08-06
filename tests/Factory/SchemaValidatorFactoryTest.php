<?php
/**
 * Copyright (C) Jyxon, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\JsonSchema\Tests\Factory;

use stdClass;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ulrack\Validator\Common\ValidatorInterface;
use Ulrack\JsonSchema\Exception\SchemaException;
use Ulrack\JsonSchema\Factory\SchemaValidatorFactory;
use Ulrack\JsonSchema\Component\Storage\StorageManager;

/**
 * @coversDefaultClass Ulrack\JsonSchema\Factory\SchemaValidatorFactory
 * @covers Ulrack\JsonSchema\Factory\Validator\ValidatorFactory
 */
class SchemaValidatorFactoryTest extends TestCase
{
    /**
     * @return void
     *
     * @covers ::createFromString
     */
    public function testCreateFromString(): void
    {
        $subject = new SchemaValidatorFactory();

        $this->assertInstanceOf(
            ValidatorInterface::class,
            $subject->createFromString('{"enum": ["foo"]}', 'foo.json')
        );
    }

    /**
     * @return void
     *
     * @covers ::createFromString
     */
    public function testCreateFromStringInvalidJson(): void
    {
        $subject = new SchemaValidatorFactory();

        $this->expectException(SchemaException::class);

        $subject->createFromString(']"foo"[');
    }

    /**
     * @return void
     *
     * @covers ::createFromLocalFile
     * @covers ::createFromRemoteFile
     * @covers ::create
     */
    public function testCreateFromLocalFile(): void
    {
        $subject = new SchemaValidatorFactory();

        $this->assertInstanceOf(
            ValidatorInterface::class,
            $subject->createFromLocalFile(__DIR__ . '/../assets/schema.json')
        );

        $this->expectException(InvalidArgumentException::class);

        $subject->createFromLocalFile(__DIR__ . '/../assets/nope.json');
    }

    /**
     * @return void
     *
     * @covers ::createFromRemoteFile
     * @covers ::create
     */
    public function testCreateFromRemoteFile(): void
    {
        $storageManager = new StorageManager();
        $subject = new SchemaValidatorFactory(null, $storageManager);
        $result = $subject->createFromRemoteFile(
            'http://json-schema.org/draft-07/schema#'
        );

        $this->assertInstanceOf(
            ValidatorInterface::class,
            $result
        );

        // Verify that the object isn't being constructed twice.
        $this->assertSame(
            $result,
            $subject->createFromRemoteFile(
                'http://json-schema.org/draft-07/schema#'
            )
        );

        $injectSchema = (object) ['type' => 'object'];
        $storageManager->getSchemaStorage()->set('foo.json', $injectSchema);
        // foo.json has been injected above, but was never built.
        $newResult = $subject->createFromRemoteFile('foo.json');
        $this->assertInstanceOf(
            ValidatorInterface::class,
            $newResult
        );
    }

    /**
     * @return void
     *
     * @covers ::__construct
     * @covers ::createVerifiedValidator
     * @covers ::createFromRemoteFile
     *
     * @dataProvider failureSchemaProvider
     */
    public function testCreateVerifiedValidatorException(
        object $schema
    ): void {
        $subject = new SchemaValidatorFactory();
        $this->expectException(SchemaException::class);
        $subject->createVerifiedValidator($schema);
    }

    /**
     * @return array
     */
    public function failureSchemaProvider(): array
    {
        return [
            [
                // no $schema set.
                (object) ['foo' => 'bar'],
            ],
            [
                // Enum must be an array.
                (object) [
                    '$schema' => 'http://json-schema.org/draft-07/schema#',
                    'enum' => new stdClass()
                ],
            ]
        ];
    }
}
