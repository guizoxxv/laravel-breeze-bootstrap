# Laravel Breeze Bootstrap

A Laravel package to use Bootstrap scaffolding with Breeze.

## Introduction

Bootstrap is not supported by default in authentication starter kits since Laravel version 8. This package combines the UI pattern on the legacy package [laravel/ui](https://github.com/laravel/ui) that uses Bootstrap, with the newer authentication starter kit [laravel/breeze](https://github.com/laravel/breeze).

## Supported versions

* Laravel 11

## Instalation

1. Require the package via Composer:

```
composer require guizoxxv/laravel-breeze-bootstrap
```

2. Install Breeze Bootstrap stack

```
php artisan breeze-bootstrap:install
```

3. Migrate your database:

```
php artisan migrate
```

4. Compile your application's frontend assets

```
npm install
npm run dev
``` 
