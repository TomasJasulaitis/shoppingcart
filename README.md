# Symfony 5 shopping cart application

## Requirements

- composer
- php > 7.4
- docker

## Installation

- run `git clone https://github.com/TomasJasulaitis/shoppingcart.git`
- run `docker-compose up -d`
- run `composer install`
- run `php bin/console doctrine:migrations:migrate` to add database tables
- run `php bin/console doctrine:fixtures:load` to load default products
- run `symfony serve` to start web server

## Configuration

- exchange rates are configured in config/services.yaml "app.currency_exchange_rates"
- default currency is configured in config/services.yaml "$defaultCurrency" variable

## Usage

- to run the application run `symfony console handleCartCommand`
