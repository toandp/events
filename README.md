# JBZoo Event  [![Build Status](https://travis-ci.org/JBZoo/Event.svg?branch=master)](https://travis-ci.org/JBZoo/Event)      [![Coverage Status](https://coveralls.io/repos/JBZoo/Event/badge.svg?branch=master&service=github)](https://coveralls.io/github/JBZoo/Event?branch=master)

#### PHP tdp/di A simple PHP event system

The EventEmitter is a simple pattern that allows you to create an object that emits events, and allow you to listen to those events.

### Install
```sh
composer require toandp/events --update-no-dev
```

### Simple example
```php
require_once './vendor/autoload.php'; // composer autoload.php

// Get needed classes
use tdp\events\EventManager;

$eManager = new EventManager();

// Simple
$eManager->on('create', function () {
    echo "Something action";
});

// Just do it!
$eManager->trigger('create');
```

### License

MIT