<?php

if (!function_exists('active')) {
    /**
     * Return the active class if the provided paths are active.
     *
     * @param  mixed $routes
     * @param  string $class
     * @return string|null
     */
    function active($routes = null, $class = null)
    {
        if (is_null($routes)) {
            return resolve('active');
        }

        $routes = is_array($routes) ? $routes : [$routes];

        return active()->active($routes, $class);
    }
}
