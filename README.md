# Phprest API Blueprint Sample Project

[![Author](http://img.shields.io/badge/author-@adammbalogh-blue.svg?style=flat-square)](https://twitter.com/adammbalogh)
[![Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE)

# Requirements

* Composer
* Php 5.4 or latest
* MySql 5.x
* NodeJS for API and Documentation Testing
* [Hercule](https://github.com/jamesramsay/hercule) for creating [API Blueprint](https://github.com/apiaryio/api-blueprint) based documentation
* [Apiary client](https://github.com/apiaryio/apiary-client) for creating [API Blueprint](https://github.com/apiaryio/api-blueprint) based documentation
* [Dredd](https://github.com/apiaryio/dredd) for testing [API Blueprint](https://github.com/apiaryio/api-blueprint) based documentation

# Installation

## 1. Create project

```cli
composer -sdev create-project phprest/phprest-api-blueprint-sample-project /path/to/your/project
```

## 2. Configure your database settings

In ```app/config/orm.php``` set your database credentials.

## 3. Create database

```cli
create database tesselboard collate=utf8mb4_unicode_ci;
```

## 4. Database migrations

*(from the root of your project dir)*

```cli
vendor/bin/phprest-service-orm migrations:migrate
```

## 5. Database fixtures

*(from the root of your project dir)*

```cli
vendor/bin/phprest-service-orm fixtures:set
```

## 6. Storage dir

*(from the root of your project dir)*

Storage dir (```app/storage```) has to be writeable by the web server.

# Create API Documentation

*(from the root of your project dir)*

```cli
hercule blueprint/0.1/blueprint.md -o public/blueprint.md;
apiary preview --path=public/blueprint.md --output=public/api_documentation.html
```

# Testing API Documentation

```cli
vendor/bin/phprest-service-orm fixtures:set
dredd public/blueprint.md http://localhost/
```

# API testing (spec tests)

*(from the root of your project dir)*

```cli
cd specs
npm install
cd ..
vendor/bin/phprest-service-orm fixtures:set
specs/node_modules/jasmine-node/bin/jasmine-node --verbose specs/tests
```

# List your routes

*(from the root of your project dir)*

```cli
vendor/bin/phprest routes:get
```

You should get something like this:

| Method  | Route                                   | Handler                                             |
|---------|-----------------------------------------|-----------------------------------------------------|
| OPTIONS | /{version:any}/camera                   | \Api\Camera\Controller\Camera::options              |
| GET     | /{version:any}/camera                   | \Api\Camera\Controller\Camera::get                  |
| POST    | /{version:any}/camera                   | \Api\Camera\Controller\Camera::post                 |
| GET     | /{version:any}/temperatures             | \Api\Temperature\Controller\Temperature::getAll     |
| POST    | /{version:any}/temperatures             | \Api\Temperature\Controller\Temperature::post       |
| OPTIONS | /{version:any}/temperatures             | \Api\Temperature\Controller\Temperature::optionsAll |
| OPTIONS | /{version:any}/temperatures/{id:number} | \Api\Temperature\Controller\Temperature::options    |
| GET     | /{version:any}/temperatures/{id:number} | \Api\Temperature\Controller\Temperature::get        |
| DELETE  | /{version:any}/temperatures/{id:number} | \Api\Temperature\Controller\Temperature::delete     |

## Nginx sample configuration

```
server {
    listen 80;
    server_name localhost;

    root /var/www/application/public;
    index index.php;

    location / {
        try_files $uri $uri/ @rewrite;
    }

    location ~ \.php$ {
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass unix:/var/run/php5-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location @rewrite {
        rewrite ^ /index.php;
    }

    error_log /var/log/nginx/application_error.log;
}
```
