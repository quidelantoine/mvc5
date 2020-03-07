<?php

namespace App\Weblitzer;

class Router
{
    private $routes = [];
    private $pages = [];

    public function __construct($routes)
    {
        $this->routes = $routes;
        $this->getAllPages();
        $urls = $this->getUrls();
        $getpage = $this->getPage($urls);

        if(in_array($getpage,$this->pages)) {
            $goodroute  = $this->getGoodRoute($getpage);
            $controller = $this->getController($goodroute);
            $method     = $this->getMethod($goodroute);
            $this->callGoodController($controller,$method,$goodroute,$urls);
        } else {
            $this->redirectTo404();
        }
    }

    private function callGoodController($controller,$method,$goodroute,$urls)
    {
        if (class_exists($controller)) {
            $instance = new $controller();
            if (method_exists($controller, $method)) {
                if (!empty($goodroute[3])) {
                    $arguments = $this->getArguments($goodroute,$urls);
                    if (count($arguments) == 1) {
                        $instance->$method($arguments[0]);
                    } elseif (count($arguments) == 2) {
                        $instance->$method($arguments[0], $arguments[1]);
                    } elseif (count($arguments) == 3) {
                        $instance->$method($arguments[0], $arguments[1], $arguments[2]);
                    } elseif (count($arguments) == 4) {
                        $instance->$method($arguments[0], $arguments[1], $arguments[2],$arguments[3]);
                    } else {
                        die('Error: max 4 arguments');
                    }
                } else {
                    if(count($urls) == 1) {
                        $instance->$method();
                    } else {
                        $this->redirectTo404();
                    }
                }
            }
        }

    }

    public function getRoutes()
    {
        return $this->routes;
    }

    private function getGoodRoute($getpage)
    {
        $key = array_search($getpage,$this->pages);
        return $this->routes[$key];
    }

    private function getPage($urls)
    {
        return empty($urls[0]) ? 'home' : $urls[0];
    }

    private function getArguments($goodroute,$urls)
    {
        $arguments = array();
        for($i= 1;$i <= count($goodroute[3]);$i++) {
            if (!empty($urls[$i])) {
                $arguments[] = $urls[$i];
            } else {
                $this->redirectTo404();
            }
        }
        return $arguments;
    }

    private function getController($goodroute)
    {
        return '\\App\\Controller\\' . ucfirst($goodroute[1]) . 'Controller';
    }

    private function getMethod($goodroute)
    {
        return $goodroute[2];
    }

    private function getUrls() : array
    {
        $config = new Config();
        $directory = $config->get('directory').'public/';
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $parse = parse_url($actual_link);
        $parse2 = str_replace($directory,'',$parse['path']);
        $urls = explode('/',$parse2);
        return $urls;
    }

    private function getAllPages()
    {
        foreach($this->routes as $route) {
            $this->pages[] = $route[0];
        }
    }

    private function redirectTo404()
    {
        $controller = new \App\Controller\DefaultController();
        $controller->Page404();
    }
}
