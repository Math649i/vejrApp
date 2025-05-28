<?php

require_once '../app/models/WeatherModel.php';
require_once '../app/views/weatherView.php';

class WeatherController {
    public function show() {
        $model = new WeatherModel();
        $city = isset($_GET['city']) ? $_GET['city'] : 'København';

        $weatherData = $model->getWeather($city);

        renderWeather($weatherData, $city);
    }
}
