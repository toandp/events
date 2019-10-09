# PHP tdp\events

#### PHP tdp/di A simple PHP event system

The EventEmitter is a simple pattern that allows you to create an object that emits events, and allow you to listen to those events.

### Install
```sh
composer require toandp/events
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