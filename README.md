# Symfony 5 shopping cart application

## Requirements

- composer
- php > 7.4
- docker

### Installation

Clone the repository

```
git clone https://github.com/TomasJasulaitis/shoppingcart.git
```
Ensure you have `docker` installed and run to setup database

```
docker-compose up -d
```

Install all dependancies

```
composer install
```

Create the database

```
php bin/console doctrine:database:create
```

Add database tables

```
php bin/console doctrine:migrations:migrate
```

Load default product fixtures

```
php bin/console doctrine:fixtures:load
```

Start the web server

```
symfony serve
```

## Configuration

- exchange rates are configured in config/services.yaml "app.currency_exchange_rates"
![exchange-rates](https://user-images.githubusercontent.com/36656940/90551484-1151ad00-e19a-11ea-96cb-5ae850b67f9f.PNG)
- default currency is configured in config/services.yaml "$defaultCurrency" variable
![default-currency](https://user-images.githubusercontent.com/36656940/90551432-fed77380-e199-11ea-8ff9-0649c733b31d.PNG)

## Usage

Run the command

```
symfony console handleCartCommand
```
