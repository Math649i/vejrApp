<?php
require_once __DIR__ . '/../controllers/WeatherController.php';

class Router {
    public function handleRequest() {
        $controller = new WeatherController();
        $controller->show();
    }
}
