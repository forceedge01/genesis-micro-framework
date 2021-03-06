define envContent
APP_PROFILE=dev
endef
export envContent

define gitignoreContent
vendor
endef
export gitignoreContent

define readmeContent
Thanks for choosing the genesis micro framework. Start off by running `make serve` to start the project and adding code to the controller
in `src/Controller`. The routes are registered in the `public/index.php` file.

Check out the project readme for more information.
endef
export readmeContent

define appContent
<?php

use Genesis\MicroFramework\Service\Config;
use Genesis\MicroFramework\Service\Router;
use Genesis\MicroFramework\Service\Request;
use App\Controller;

require __DIR__ . '/../vendor/autoload.php';
/**
 * Set the `APP_PROFILE` environment variable to use the appropriate config file. 
 */
$$env = getenv('APP_PROFILE');
if (!$$env) {
    $$env = 'dev';
}
require __DIR__ . '/../src/Config/config-'. $$env .'.php';

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

define profileConfigContent
<?php

use Genesis\MicroFramework\Service\Config;

require __DIR__ . '/config.php';

Config::set('site_url', 'https://localhost:8000');
endef
export profileConfigContent

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
<!DOCTYPE>
<html>
<head>
	<title>Genesis MicroFramework!</title>
</head>
<body>
	<h1>Hello Genesis user! Start coding...</h1>

	<p>Thanks for choosing the genesis micro framework. Start off by running `make serve` to start the project and adding code to the controller
	in `src/Controller`. The routes are registered in the `public/index.php` file.</p>

	<p>Check out the project readme for more information.</p>
</body>
</html>
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

	touch .env
	touch .gitignore
	touch README.md
	touch public/index.php
	touch src/Config/config.php
	touch src/Config/config-dev.php
	touch src/Config/config-prod.php
	touch src/Controller/Index.php
	touch src/View/index.php
	touch Makefile

	echo "$$readmeContent" >> README.md
	echo "$$gitignoreContent" >> .gitignore
	echo "$$envContent" >> .env
	echo "$$appContent" >> public/index.php
	echo "$$controllerContent" >> src/Controller/Index.php
	echo "$$viewContent" >> src/View/index.php
	echo "$$configContent" >> src/Config/config.php
	echo "$$profileConfigContent" >> src/Config/config-dev.php
	echo "$$profileConfigContent" >> src/Config/config-prod.php
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
