## Laravel Datatables
[![Latest Stable Version](https://poser.pugx.org/inivate/datatable-laravel/v/stable.png)](https://packagist.org/packages/inivate/datatable-laravel)
[![Total Downloads](https://poser.pugx.org/inivate/datatable-laravel/downloads.png)](https://packagist.org/packages/inivate/datatable-laravel)
[![Build Status](https://travis-ci.org/yajra/laravel-datatables.png?branch=master)](https://travis-ci.org/yajra/laravel-datatables)
[![Latest Unstable Version](https://poser.pugx.org/inivate/datatable-laravel/v/unstable.svg)](https://packagist.org/packages/inivate/datatable-laravel)
[![License](https://poser.pugx.org/inivate/datatable-laravel/license.svg)](https://packagist.org/packages/inivate/datatable-laravel)

This package is created to handle server-side requests of DataTables jQuery Plugin via AJAX option. It uses [DataTables](http://datatables.net/) jQuery Plugin

## Installation

Install the package through [Composer](http://getcomposer.org/). 

Run the Composer require command from the Terminal:

    composer require inivate/datatable-laravel
    
If you're using Laravel 5.5, this is all there is to do. 

Should you still be on version 5.4 of Laravel, the final steps for you are to add the service provider of the package and alias the package. To do this open your `config/app.php` file.

Add a new line to the `providers` array:

	Inivate\DatatableLaravel\DatatableServiceProvider::class


Now you're ready to start using Laravel Datatables in your application.

## Overview
Look at one of the following topics to learn more about Laravel Datatables

* [Usage](#usage)

## Usage

Laravel Datatables gives you the following methods to use:

```php
(new DataTable(User::class, UserResource::class))
        ->addColumn('Id', 'id', true, true)
        ->addColumn('First Name', 'first_name', true, true)
        ->addColumn('Last Name', 'last_name', true, true)
        ->addColumn('Created At', 'created_at', true, true)
        ->build();
```      

<!-- Adding an item to the cart is really simple, you just use the `add()` method, which accepts a variety of parameters. -->
