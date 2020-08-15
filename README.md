Genesis micro framework
-----------------

Bunch of classes with a bit of convention to get your started.

Place the following code in your index file. Assuming that:

- the index file is in the public folder.
- you have an autoloading rule in composer.json file that points the namespace App\Controller to your controllers folder.

```php
<?php

use Genesis\Microframework\Service\Config;
use Genesis\Microframework\Service\Router;
use Genesis\Microframework\Service\Request;
use App\Controller;

require __DIR__ . '/../vendor/autoload.php';

$router = new Router($_GET, $_SERVER);
$router->registerRoutes(
    [
        '/' => Controller\Index::class,
    ]
);

Config::set('view_path', __DIR__ . '/../src/View/');
$router->dispatchRequest(new Request());
```

The dispatcher will call upon the index() method in each controller only.

To add database support, add config for database like so in the above file before the `dispatchRequest()` call:

```php
Config::set('db_params', [
    'dbengine' => 'mysql',
    'host' => 'localhost',
    'port' => 3306,
    'dbname' => 'myDB',
    'username' => 'root',
    'password' => 'password'
]);
```

And call upon the `getMapperService()` method to persist your models. For more information follow guide here https://github.com/forceedge01/genesis-persistence.

Call a view in your controller like so:

```php
# src/Controller/Index
<?php

namespace App\Controller;

use Genesis\MicroFramework\Controller\BaseController;

/**
 * Index class.
 */
class Index extends BaseController
{
    public function index()
    {
        echo $this->render('index.php', [
            'name' => 'Abdul'
        ]);
    }
}
```

Expect to have a view file `src/View/index.php` which renders the variable `name`.
