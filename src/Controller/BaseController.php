<?php

namespace Genesis\MicroFramework\Controller;

use Exception;
use Genesis\MethodPersister\FilePersistenceRepository;
use Genesis\MethodPersister\Persister;
use Genesis\MicroFramework\Service\Config;
use Genesis\MicroFramework\Service\Request;
use Genesis\MicroFramework\Service\Router;
use Genesis\Services\Persistence;

class BaseController
{
    public static $viewPath;

    protected $request;

    protected static $router;

    protected static $methodPersister;

    protected static $databaseService;

    protected static $mapperService;

    /**
     * Set this array to the configs you'd like to inject.
     *
     * @var array
     */
    protected $injectConfigs = [];

    public function __construct(Router $router, Request $request)
    {
        $this->request = $request;
        self::$router = $router;
        self::$methodPersister = new Persister(new FilePersistenceRepository(sys_get_temp_dir() . '/cache/'));
    }

    public function getMapperService()
    {
        if (!self::$mapperService) {
            $config = Config::get('db_params');

            if (!$config) {
                throw new Exception('Cannot instantiate mapper service without db_params settings.');
            }

            self::$databaseService = new Persistence\DatabaseService(Config::get('db_params'));
            self::$mapperService = new Persistence\MapperService(self::$databaseService);    
        }

        return self::$mapperService;
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function asset(string $path)
    {
        return $this->request->getHostAdaptiveScheme() . '/assets/' . $path;
    }

    public function render(string $view, array $args = [])
    {
        foreach ($this->injectConfigs as $config) {
            $args[$config] = Config::get($config);
        }

        extract($args);
        $path = Config::get('view_path') . $view;

        if (! file_exists($path)) {
            throw new Exception("View '$view' not found at '$path'.");
        }

        ob_start();
        require $path;
        return ob_get_clean();
    }
}
