<?php

namespace app\core;

class App {
    private $controller;
    private $method;
    private $params;
    private $URLArray;
    private $startIndexFromUrl;
    private $pageNotFound;

    public function __construct() {
        $this->controller = 'Home';
        $this->method = 'index';
        $this->params = [];
        $this->startIndexFromUrl = 3; 
        $this->pageNotFound = false;

        $this->parseURL();
        $this->setController();
        $this->setMethodFromUrl();
        $this->setParamsFromUrl();

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseURL() {
        $this->URLArray = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    }

    private function setController() {
        $controller = $this->URLArray[$this->startIndexFromUrl] ?? '';

        if (!empty($controller)) {
            $controllerFile = 'app/controllers/' . ucfirst($controller) . '.php';
            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controllerClass = 'app\\controllers\\' . ucfirst($controller);
                $this->controller = new $controllerClass();
                return;
            } else {
                $this->pageNotFound = true;
            }
        }

        // Controlador por defeito (Home)
        require_once 'app/controllers/Home.php';
        $controllerClass = 'app\\controllers\\Home';
        $this->controller = new $controllerClass();
    }

    private function setMethodFromUrl() {
        $url = $this->URLArray;
        $startIndex = $this->startIndexFromUrl + 1;

        $requested = $url[$startIndex] ?? '';

        if (!empty($requested) && isset($url[$startIndex])) {
            // Map numeric genre names to valid method names
            $mapping = [
                '1genre' => 'onegenre',
                '2genre' => 'twogenre',
                '3genre' => 'threegenre'
            ];

            $methodToCheck = $mapping[$requested] ?? $requested;

            if (method_exists($this->controller, $methodToCheck) && !$this->pageNotFound) {
                $this->method = $methodToCheck;
            } else {
                $this->method = 'pageNotFound';
            }
        }
    }

    private function setParamsFromUrl() {
        $url = $this->URLArray;
        $startIndex = $this->startIndexFromUrl + 2;

        if (count($url) > $startIndex) {
            $this->params = array_slice($url, $startIndex);
        }
    }
}

/*
NOTAS:
Exemplos de URIs (em testes locais):
http://localhost
http://localhost/movie/ - invoca método index() do controlador Movie
http://localhost/movie/get/5 - invoca método get() do controlador Movie
*/
