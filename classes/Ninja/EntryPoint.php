<?php

namespace Ninja;

use Ninja\Routes;

class EntryPoint
{
    private $route;
    private $method;
    private $routes;

    public function __construct(string $route, string $method, Routes $routes)
    {
        $this->route = $route;
        $this->routes = $routes;
        $this->method = $method;
        $this->checkUrl();
    }

    public function checkUrl()
    {
        if ($this->route !== strtolower($this->route)) {
            http_response_code(301);
            header('Location:' . strtolower($this->route));
        }
    }

    public function loadTemplate($templatFileName, $variables = [])
    {
        extract($variables);

        ob_start();

        require __DIR__ . '/../../template/' . $templatFileName;

        return ob_get_clean();
    }

    public function run()
    {
        $routes = $this->routes->getRoutes();
        $authentication = $this->routes->getAuthentication();

        if (isset($routes[$this->route]['login']) && isset($routes[$this->route]['login']) && !$authentication->isLoggedIn()) {
            header("Location: /login/error");
        } else if (isset($routes[$this->route]['permission']) && !$this->routes->checkPermission($$routes[$this->route]['permission'])) {
            header('Location: /category/error');
        } else {
            $controller = $routes[$this->route][$this->method]['controller'];
            $action = $routes[$this->route][$this->method]['action'];

            $page = $controller->$action();

            $title = $page['title'];

            if (isset($page['variables'])) {
                $output = $this->loadTemplate($page['template'], $page['variables']);
            } else {
                $output = $this->loadTemplate($page['template']);
            }

        }
        echo $this->loadTemplate('layout.html.php', ['loggedIn' => $authentication->isLoggedIn(), 'output' => $output, 'title' => $title]);
    }
}