# MyHammer challenge
### Job Request API

##### How to run?
Tech stack is: php 7.1, symfony 4.
No MySQL is required. Both tests and dev environment have been setup to persist in sqlite dbs inside /var directory. "challenge.db" and "challenge_test.db" are the filenames.

0. Create a `.env` file by copying the `.env.dist` file and configure.
1. Install dependencies: `composer install`
2. Create the schema: `bin/console doctrine:schema:create`
3. Load fixtures: `bin/console doctrine:fixtures:load`
4. Run server: `bin/console server:run`
5. Run tests: `vendor/phpunit/phpunit/phpunit` (Code coverage reports are generated in the `codecoverage/index.html` file)
6. Send requests by default to `http://localhost:8000` (Check swagger.yaml file and use an HTTP client like Postman or just curl).

#### Additional implementation notes:
-Location model has been created as a separated entity, so it can be fetched by frontend for autocomplete purposes before job request creation, so instead of zipcode or PLZ, the job request payload requires a locationId numeric parameter.
-Same principle has been applied to user and category. Both models have own entities.
