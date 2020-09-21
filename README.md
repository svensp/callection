# nested-callable-collection

nested callable collection helps you keep track of 'something' that is used by
callables like closures.

There are 2 componentes to this

- a stack keeping track of the 'current' item
- a collection, saving the items by name or index of appearance

## Install

nested-callable-collection is installed via composer

  composer require svensp/nested-callable-collection

## Use case

The idea behind nested-callable-collection is to support the following way of
defining the world in a unit test:

```php
$this->asUser(function() {
  $this->withGame(function() {

    $this->withUser(function() {
      $this->withUnit();
    });

    $this->withUser();
  });
});
```
