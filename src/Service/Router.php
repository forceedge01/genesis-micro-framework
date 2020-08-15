<?php

namespace Genesis\MicroFramework\Service;

/**
 * Router class.
 */
class Router
{
    public $get;

    public $server;

    private $routes;

    public function __construct(array $get, array $server)
    {
        $this->get = $get;
        $this->server = $server;
        $this->url = parse_url($this->server['REQUEST_URI']);
        $this->path = $this->url['path'];
    }

    public function registerRoutes(array $routes)
    {
        $this->routes = $routes;
    }

    public function dispatchRequest(Request $request)
    {
        $route = $this->path;

        if (!$route) {
            $route = '/';
        }

        $this->dispatch($route, $request);
    }

    public function dispatch($route, Request $request)
    {
        if (! isset($this->routes[$route])) {
            $this->redirect('/');
        }

        (new $this->routes[$route]($this, $request))->index();
    }

    public function redirect($route, $status = 200, array $query = [])
    {
        header('Location: ' . $route . ($query ? http_build_query($query) : ''));
        exit;
    }
}
