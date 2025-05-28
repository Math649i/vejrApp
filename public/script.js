function getWeather() {
    const city = document.getElementById("cityInput").value;
    fetch(`api.php?city=${city}`)
        .then(res => res.text())
        .then(data => {
            document.getElementById("weatherResult").innerHTML = data;
        });
}

document.getElementById("weatherResult").innerHTML = data;
document.getElementById("weatherResult").classList.add("fade-in");
