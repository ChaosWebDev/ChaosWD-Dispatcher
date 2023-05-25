Install:

```
composer require chaoswd/dispatcher
```

Instantiate:

```
require(__DIR__ . "/../../vendor/autoload.php");

use Order\Dispatcher;

$router = Dispatcher::loadRoutes(path/to/routes.php);
```

path/to/routes.php should be from the page that is calling it to whever you have it. Be sure to include routes.php in the call to loadRoutes()<br><br>

When you want to trigger it:

```
$router->dispatcher($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
```

routes.php

```
$router->get('/', 'Order\Controller', 'ViewController@getView');
```

routes.php has the method `$router->$method` of either 'GET' or 'POST'.<br>
in the `()` you need 3 parts:

1. the URI (such as '/login').<br>
2. the namespace of the controller you want to use. ViewController's namespace is `Order\Controller`.<br>
3. the name of the controller@method | ViewController@setView sends the request to the setView method of ViewController.<br>
