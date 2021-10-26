# Knownonline Challenge
## Requirements
```sh
php: ^7.2.5
mysql: >= 5.6
composer: >= 1.0
```


## Installation

```sh
git clone https://github.com/Gustavovaler/known-challenge.git
cd known-challenge
composer install
```

Now rename .env.example to .env and set your config data

ACCOUNT_NAME=client-account-name  \
API_KEY=X-VTEX-API-AppKey  \
API_TOKEN=X-VTEX-API-AppToken  

```sh
$ php artisan key:generate
$ php artisan migrate
```

# Usage

Get sales from 2021

```sh
$ php artisan sales:get 
```
### Optional

You can also get sales from another year

```sh
$ php artisan sales:get --year [year]
```

