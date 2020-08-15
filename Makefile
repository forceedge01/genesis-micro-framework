define appContent
<?php

use Genesis\MicroFramework\Service\Config;
use Genesis\MicroFramework\Service\Router;
use Genesis\MicroFramework\Service\Request;
use App\Controller;

require __DIR__ . '/../vendor/autoload.php';

$$router = new Router($$_GET, $$_SERVER);
$$router->registerRoutes(
    [
        '/' => Controller\Index::class,
    ]
);

Config::set('view_path', __DIR__ . '/../src/View/');
$$router->dispatchRequest(new Request());
endef
export appContent

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

.PHONY: build
build:
	mkdir -p public
	mkdir -p src/Controller
	mkdir -p src/View

	touch public/index.php
	touch src/Controller/Index.php
	touch src/View/index.php


	echo "$$appContent" >> public/index.php
	echo "$$controllerContent" >> src/Controller/Index.php
	echo "$$viewContent" >> src/View/index.php
	echo '[NEXT STEP]: Add autoload snippet to composer.json file and run `composer dumpautoload` from command line.';
	echo '"autoload": {\
        "psr-4": {\
            "App\\": "src/"\
        }\
    }';

.PHONY: cleanup
cleanup:
	rm -rf public src