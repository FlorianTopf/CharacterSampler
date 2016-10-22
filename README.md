## Sample streamed characters

### Installation

`composer install`

### Tests

`vendor/bin/phpunit --configuration=src/Rg/phpunit.xml`

###  Examples

`php characterSampler.php --type local --size 50`

`php characterSampler.php --type remote --size 100`

`cat sample.txt | php characterSampler.php --size 100`

