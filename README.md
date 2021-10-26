# Knownonline Challenge
## Requirements
```sh
php: ^7.2.5
mysql: > 5.6
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

```sh
$ php artisan sales:get
```

