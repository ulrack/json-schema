# Contributing

To contribute to this package, please keep to these guidelines.

- Fork the package.
- Create a branch per feature.
- Commit your changes to these branches.
- Create a pull request per feature to the master branch of the original repository.

## Pull requests

Pull request should follow these rules, before they can get accepted.

- Follow the [pull request template](PULL_REQUEST_TEMPLATE.md).
- Contains a short but complete description.
- Has passed all test command listed bellow.

## Running Tests

``` bash
$ vendor/bin/phpunit --coverage-text
$ vendor/bin/phpcs src/ tests/
```

## Notes

Multiple commits per feature are allowed, but please provide a good description in your pull request.
This description will be used to squash your feature into the master branch.
