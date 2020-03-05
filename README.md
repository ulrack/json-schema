[![Build Status](https://travis-ci.com/ulrack/json-schema.svg?branch=master)](https://travis-ci.com/ulrack/json-schema)

# Ulrack JSON Schema

This package contains a [JSON schema](https://json-schema.org/) validator
library for PHP. It support Draft 07 and 06.

To get a grip on JSON schema's, what they are and how they work, please see the
manual of [json-schema-org](https://json-schema.org/learn/).

The package generates a reusable validation object, which can be used to verify
data against.

## Installation

To install the package run the following command:

```
composer require ulrack/json-schema
```

## Usage

Before a validation object can be created, the factory for the validators needs
to be instantiated. This can be done by using the following snippet:
```php
<?php

use Ulrack\JsonSchema\Factory\SchemaValidatorFactory;

$factory = new SchemaValidatorFactory();
```

All of the below described method of generating a validation object will result
in a [ValidatorInterface](https://github.com/ulrack/validator/blob/master/src/Common/ValidatorInterface.php).
To verify data against this object, simply pass the data to the `__invoke`
method, like so:
```php
<?php

use Ulrack\Validator\Common\ValidatorInterface;

/** @var ValidatorInterface $validator */
$validator($myData); // returns true or false.
```

After the factory is created there are 4 options to create the validation object.

### Object injection

If an object is already created by a (for example) a previous call to
`json_decode` (second parameter must be either null or false, to get an object).

The validation object can be created by calling the `create` method on the
previously instantiated `SchemaValidatorFactory`.

```php
<?php

use Ulrack\JsonSchema\Factory\SchemaValidatorFactory;

/** @var object|bool $schema */
/** @var SchemaValidatorFactory $factory */
$factory->create($schema);
```

It is also possible to create a verified validation object.
This is possible when the `$schema` property is set on the
provided schema. The schema will then be validated against
the schema which is defined on the property. This can be
done with the following snippet:

```php
<?php

use Ulrack\JsonSchema\Factory\SchemaValidatorFactory;

/** @var object|bool $schema */
/** @var SchemaValidatorFactory $factory */
$factory->createVerifiedValidator($schema);
```

### Local file

To create a validator object from a local schema file, it is also possible to
reference this file location to a method and let this method load it. This
can be done with the following snippet:
```php
<?php

use Ulrack\JsonSchema\Factory\SchemaValidatorFactory;

/** @var SchemaValidatorFactory $factory */
$factory->createFromLocalFile('path/to/my/schema.json');
```

### Remote file

A schema can also be loaded from a remote location, for example:
[http://json-schema.org/draft-07/schema#](http://json-schema.org/draft-07/schema#).
To load a schema from a remote location, use the following method:
```php
<?php

use Ulrack\JsonSchema\Factory\SchemaValidatorFactory;

/** @var SchemaValidatorFactory $factory */
$factory->createFromRemoteFile('http://json-schema.org/draft-07/schema#');
```

### From string

If a validation object needs to be created from a JSON string, use the method
`createFromString`.

```php
<?php

use Ulrack\JsonSchema\Factory\SchemaValidatorFactory;

/** @var SchemaValidatorFactory $factory */
$factory->createFromString(
    '{"$ref": "http://json-schema.org/draft-07/schema#"}'
);
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## MIT License

Copyright (c) 2019 GrizzIT

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
