# sync-json-cli-filter-schematize-app
This app can be used to filter json and schematize it

PHP 7.4 required to use it.
There is test.json in this repository.

# You can use following commands to see how it works.

## To see all distinct array keys:
php bin/console json-op --keys test.json 

## Schematize json arrays with null key=>value pairs:
php bin/console json-op --schematize test.json 

## To filter given range:
php bin/console app:json-op  test.json age 28 30 

# To test if cli app is working 

php bin/phpunit tests/Command/JsonOpCommandTest.php 
