define appContent
<?php

use Genesis\MicroFramework\Service\Config;
use Genesis\MicroFramework\Service\Router;
use Genesis\MicroFramework\Service\Request;
use App\Controller;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Config/Config.php';

$$router = new Router($$_GET, $$_SERVER);
$$router->registerRoutes(
    [
        '/' => Controller\Index::class,
    ]
);

$$router->dispatchRequest(new Request());
endef
export appContent

define configContent
<?php

use Genesis\MicroFramework\Service\Config;

Config::set('view_path', __DIR__ . '/../View/');
endef
export configContent

define controllerContent
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
        echo $$this->render('index.php');
    }
}
endef
export controllerContent

define viewContent
hello world!
endef
export viewContent

define makeContent
.PHONY: serve
serve:
	composer dumpautoload
	php -S localhost:8000 -t public
endef
export makeContent

.PHONY: build
build:
	mkdir -p public
	mkdir -p src/Controller
	mkdir -p src/Config
	mkdir -p src/View

	touch public/index.php
	touch src/Config/Config.php
	touch src/Controller/Index.php
	touch src/View/index.php
	touch Makefile

	echo "$$appContent" >> public/index.php
	echo "$$controllerContent" >> src/Controller/Index.php
	echo "$$viewContent" >> src/View/index.php
	echo "$$configContent" >> src/Config/Config.php
	echo "$$makeContent" >> Makefile
	echo '[NEXT STEP]: Add autoload snippet to composer.json file and run `composer dumpautoload` from command line.';
	echo '"autoload": {\
    "psr-4": {\
        "App\\\\": "src/"\
    }\
}';

.PHONY: cleanup
cleanup:
	rm -rf public src Makefile