# ABSS Portal
> An online portal for ABSS customers

## Builds & Statuses
[ ![Codeship Status for abss-engineering/portal-app](https://app.codeship.com/projects/2c0c5170-a9ba-0136-ea94-5efb6fdf0165/status?branch=master)](https://app.codeship.com/projects/308905)


## Installation

```sh
composer install
```

## Tests

```sh
vendor/bin/phpunit
```


## CI & Deployments

We use [codeship](https://app.codeship.com/projects/308905) and [envoyer](https://envoyer.io/projects/41669) for testing and deployments to a [server managed by Forge](https://forge.laravel.com/servers/252727).

### Setup commands
For Setup, the following configuration can be used for codeship.

```
# We support all major PHP versions. Please see our documentation for a full list.
# https://documentation.codeship.com/basic/languages-frameworks/php/
#
# By default we use the latest PHP version from the 5.5 release branch, but Laravel
# requires at least version 5.6.4
phpenv local 7.2
# Install MySQL 5.7
curl -sSL https://raw.githubusercontent.com/codeship/scripts/master/packages/mysql-5.7.sh | bash -s
# Codeship has one set of env vars, our config uses another set. Lets re-export them with the right var names.
export DB_HOST="127.0.0.1"
export DB_PORT=3307
export DB_DATABASE=test
export DB_USERNAME=$MYSQL_USER
export DB_PASSWORD=$MYSQL_PASSWORD
# Install extensions via PECL
#pecl install -f memcache
# Prepare cache directory and install dependencies
mkdir -p ./bootstrap/cache
composer install --no-interaction
cp .env.example .env
php artisan key:generate
# Prepare the test database
echo "CREATE DATABASE $DB_DATABASE;" | mysql --user=$DB_USERNAME --password=$DB_PASSWORD -h $DB_HOST --port=3307
php artisan migrate --force
```

### For running tests
For running tests, the following configuration can be used for codeship.

```
vendor/bin/phpunit
```

### Deployment
Deployment is managed by envoyer. You can trigger it with the following command. Make sure that `ENVOYER_URL` is configured in the environment variables in codeship.

```
wget $ENVOYER_URL
```
