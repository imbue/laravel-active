<?php

namespace Tijdmachine\Active;

use Illuminate\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;

class Active
{
    /**
     * Illuminate Request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Illuminate Router instance.
     *
     * @var \Illuminate\Routing\Router
     */
    protected $router;

    /**
     * Illuminate Config instance.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * ActiveRoute constructor.
     *
     * @param Request $request
     * @param Router $router
     * @param Repository $config
     */
    public function __construct(Request $request, Router $router, Repository $config)
    {
        $this->request = $request;
        $this->router = $router;
        $this->config = $config;
    }

    /**
     * Determine if any of the provided paths are active.
     *
     * @param  mixed $routes
     * @return bool
     */
    public function isActive($routes)
    {
        $routes = is_array($routes) ? $routes : func_get_args();

        if ($this->isPath($routes) || $this->isRoute($routes)) {
            return true;
        }

        return false;
    }

    /**
     * Return the active class if the provided paths are active.
     *
     * @param  mixed $routes
     * @param  string $class
     * @return string|null
     */
    public function active($routes, $class = null)
    {
        $routes = (array)$routes;

        if ($this->isActive($routes)) {
            return $this->getActiveClass($class);
        }
    }

    /**
     * Determine if the current path is one of the provided paths.
     *
     * @param  mixed $routes
     * @return boolean
     */
    public function isPath($routes)
    {
        $routes = is_array($routes) ? $routes : func_get_args();

        return call_user_func_array([$this->request, 'is'], $routes);
    }

    /**
     * Determine if the current route is one of the provided routes.
     *
     * @param  mixed $routes
     * @return boolean
     */
    public function isRoute($routes)
    {
        $routes = is_array($routes) ? $routes : func_get_args();

        return call_user_func_array([$this->router, 'is'], $routes);
    }

    /**
     * Return the active class if it is provided, otherwise fall back
     * to the class set in the configuration.
     *
     * @param  string $class
     * @return string
     */
    protected function getActiveClass($class = null)
    {
        return $class ?: $this->config->get('active.class');
    }
}
