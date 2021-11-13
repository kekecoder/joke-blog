<?php

class EntryPoint
{
    private $route;
    private $routes;

    public function __construct($route, $routes)
    {
        $this->route = $route;
        $this->routes = $routes;
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

        require __DIR__ . '/../template/' . $templatFileName;

        return ob_get_clean();
    }

    public function run()
    {
        $page = $this->routes->callACtion($this->route);

        $title = $page['title'];

        if (isset($page['variables'])) {
            $output = $this->loadTemplate($page['template'], $page['variables']);
        } else {
            $output = $this->loadTemplate($page['template']);
        }

        include __DIR__ . '/../template/layout.html.php';
    }
}
