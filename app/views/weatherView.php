<?php

function renderWeather($data, $city) {
    if (!$data || !isset($data['current_weather'])) {
        echo "<p>Der opstod en fejl – prøv et andet bynavn.</p>";
        return;
    }

    $dage = [
        'Monday' => 'Mandag',
        'Tuesday' => 'Tirsdag',
        'Wednesday' => 'Onsdag',
        'Thursday' => 'Torsdag',
        'Friday' => 'Fredag',
        'Saturday' => 'Lørdag',
        'Sunday' => 'Søndag'
    ];

    $current = $data['current_weather'];
    echo "<h2>Aktuelt vejr i " . htmlspecialchars($city) . "</h2>";
    echo "<img src='https://openweathermap.org/img/wn/10d@2x.png' alt='Vejr ikon' style='width:60px;height:60px;'>";
    echo "<p>Temperatur: " . round($current['temperature']) . "&deg;C</p>";
    echo "<p>Vind: " . round($current['windspeed']) . " km/t</p>";

    if (isset($data['daily'])) {
        echo "<h3>5-dages vejrudsigt</h3>";
        echo "<section class='forecast-row'>";

        $dates = $data['daily']['time'];
        $maxTemps = $data['daily']['temperature_2m_max'];
        $minTemps = $data['daily']['temperature_2m_min'];
        $weatherCodes = $data['daily']['weathercode'];
        function getWeatherIcon($code) {
            $map = [
                0 => '01d', 1 => '02d', 2 => '03d', 3 => '04d',
                45 => '50d', 48 => '50d', 51 => '09d', 53 => '09d',
                55 => '09d', 56 => '13d', 57 => '13d', 61 => '10d',
                63 => '10d', 65 => '10d', 66 => '13d', 67 => '13d',
                71 => '13d', 73 => '13d', 75 => '13d', 77 => '13d',
                80 => '09d', 81 => '09d', 82 => '09d', 85 => '13d',
                86 => '13d', 95 => '11d', 96 => '11d', 99 => '11d'
            ];
            return isset($map[$code]) ? $map[$code] : '01d';
        }
        for ($i = 0; $i < count($dates); $i++) {
            $timestamp = strtotime($dates[$i]);
            $englishDay = date('l', $timestamp);
            $dayName = isset($dage[$englishDay]) ? $dage[$englishDay] : $englishDay;
            $formatted = $dayName . ' ' . date('d/m', $timestamp);
            $max = round($maxTemps[$i]);
            $min = round($minTemps[$i]);
            $icon = getWeatherIcon($weatherCodes[$i]);

            echo "<article class='forecast-item'>";
            echo "<h4>$formatted</h4>";
            echo "<img src='https://openweathermap.org/img/wn/{$icon}@2x.png' alt='Vejr ikon' style='width:50px;height:50px;'>";
            echo "<p>Max: $max&deg;C</p>";
            echo "<p>Min: $min&deg;C</p>";
            echo "</article>";
        }
        echo "</section>";
    }
}
