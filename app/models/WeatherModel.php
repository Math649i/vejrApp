<?php

class WeatherModel {
    public function getCoordinates($city) {
        $url = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($city);
        $options = [
            'http' => [
                'header' => "User-Agent: vejrapplikation/1.0\r\n"
            ]
        ];
        $context = stream_context_create($options);
        $response = file_get_contents($url, false, $context);

        $data = json_decode($response, true);
        if (!empty($data)) {
            return [
                'lat' => $data[0]['lat'],
                'lon' => $data[0]['lon']
            ];
        }
        return null;
    }

    public function getWeather($city) {
        $coords = $this->getCoordinates($city);
        if (!$coords) return null;

        $lat = $coords['lat'];
        $lon = $coords['lon'];
        $url = "https://api.open-meteo.com/v1/forecast?latitude={$lat}&longitude={$lon}&current_weather=true&daily=temperature_2m_max,temperature_2m_min,weathercode&timezone=Europe/Copenhagen";

        $response = file_get_contents($url);
        return json_decode($response, true);
    }
}
