<?php namespace core;

class App
{
    protected $controller = '\controllers\home';
    protected $controllerName = 'home';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {   
        $url = $this->parseURL();
        error_log(BASEURL);
        error_log(DB_USER);
        error_log(DB_PASS);

        // controller
        if (file_exists('../app/controllers/' . $url["controller"] . '.php')) {
            $this->controller = '\controllers\\'.$url["controller"];
            $this->controllerName = $url["controller"];
            unset($url["controller"]);
        }
        include_once '../app/controllers/' . $this->controllerName . '.php';
        $this->controller = new $this->controller;

        // method
        if (isset($url["method"])) {
            if (method_exists($this->controller, $url["method"])) {
                $this->method = $url["method"];
                unset($url["method"]);
            }
        }
        // params
        if (!empty($url)) {
            $this->params = array_values($url);
        }
        
        // run controller & method, send params
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    {
        $uri = $_SERVER['REQUEST_URI'];
        if (isset($uri)) {
            $url = rtrim($uri, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            $last = array_search("public", $url);
            if (array_key_exists($last+1, $url)) {
                $parse["controller"] = $url[$last+1];
            } else {
                $parse["controller"] = null;
            }
            if (array_key_exists($last+2, $url)) {
                $parse["method"] = explode("?", $url[$last+2])[0];
            } else {
                $parse["method"] = null;
            }
            error_log("new method: ". print_r($url, true) . print_r($parse, true));
            return $parse;
        }
    }
}
