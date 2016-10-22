composer install

vendor/bin/phpunit --configuration=src/Rg/phpunit.xml

php characterSampler.php --type local --size 10
php characterSampler.php --type remote --size 100
cat sample.txt | php characterSampler.php --size 100
