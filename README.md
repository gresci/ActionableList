# ActionableList

[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)

This is a package for **Laravel 5.5** that lets you easily create tables of items, especially for administration panels. It requires **PHP 7.1**.

**Please bear in mind that this package is under development**, it is not stable for production yet. For example, new releases could introduce breaking changes. Thank you.

## Install

You can easily install this package via `composer`:
``` bash
composer require gasparilab/actionablelist
```

This package supports the new Laravel service provider autodiscovery, so there's no need to put it manually into the `providers` array in `config/app.php`.

If you want to customize the tables HTML code (you probably will!), you can publish the included views into your project with the following Artisan command:
``` bash
php artisan vendor:publish --tag=actionablelist --force
```

This will copy the views to the `resources/views/vendor/actionablelist` folder of you app, so you can customize them and keep them versioned. The `--force` parameter overwrites any existing view with the same name, it's useful if you're updating this package from an old version.

## Usage

### Complete syntax for creating a Table
``` php
// Instantiate a new Table
$table = new Table();

// Add columns
$table->addColumns(['Quantity', 'Color', 'Animal']);

// Add the dataset
$table->addDataset([
    ['one', 'red', 'cat'],
    ['two', 'green', 'bird'],
    ['three', 'blue', 'dog'],
]);

// Set the formatter for a column
$table->columns[0]->setFormatter(function ($animals) {
    return 'The color is ' . $animals[1];
});
```

### Quickly creating a Table
You can also quickly create a new Table using the static `make()` function. The first parameter is an array of the columns, the second parameters is an array of formatters for each column, the third parameter is the dataset.

Example: creating a table with three columns and two items inside.
``` php
$table = Table::make([
    'id' => 'ID',
    'title' => 'Title',
    'created_by' => 'Author',
], [
    function ($row) {
        return 'ID: ' . $row[0];
    },
    function ($row) {
        // Return the title
        return $row[1];
    },
    function ($row) {
        return new HtmlString('<em>The author is:</em> ' . $row[2]);
    },
], [
    [1, 'Lorem Ipsum', 'John Doe'],
    [2, 'Dolor Sit', 'Pippo Pluto'],
    // ...more rows...
]);
```

The Table also has a fluent interface which lets you to chain methods, like the Query Builder.
``` php
Table::addColumns($columns)->addDataset($data)->addFormatters($formatters); // ...and so on
```

### Datasets
Datasets can be arrays, Collections, Eloquent Collections or any other [iterable](http://php.net/manual/en/language.types.iterable.php) which also implements the ArrayAccess interface.

### Printing the table inside the view

In you Blade view you can print the Table this way:
``` php
@include('actionablelist::table')
```

## Testing

``` bash
vendor/bin/phpunit vendor/gasparilab/actionablelist/tests
```

## Postcardware

This package is [MIT-licensed](LICENSE.md), but if it makes it to your production environment we'd appreciate if you send us a postcard from your hometown. Our address is:
```
GaspariLab
via Minghetti, 18
40057 Cadriano di Granarolo E. (BO)
ITALY
```

## Credits

A package made by *Luca Andrea Rossi* for GaspariLab S.r.l.
