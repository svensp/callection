# closure-stack

Closure stack keeps track of the current 'something' in nested closure calls

## Install

closure-stack is installed via composer

  composer require svensp/closure-stack

## Use case

The idea behind closure stack is to support the following way of defining the
world in a unit test:

```php
$this->asUser(function() {
  $this->withGame(function() {

    $this->withUser(function() {
    });

    $this->withUser();
  });
});
```
