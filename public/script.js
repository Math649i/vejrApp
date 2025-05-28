function getWeather() {
    const city = document.getElementById("cityInput").value;
    fetch(`api.php?city=${city}`)
        .then(res => res.text())
        .then(data => {
            document.getElementById("weatherResult").innerHTML = data;
            document.getElementById("printBtn").hidden = false;
        })
        .catch(() => {
            document.getElementById("weatherResult").innerHTML = "Der opstod en fejl – prøv et andet bynavn.";
            document.getElementById("printBtn").hidden = true;
        });
}

function compareCities(event) {
    event.preventDefault();

    const city1 = document.getElementById("city1").value.trim();
    const city2 = document.getElementById("city2").value.trim();

    if (!city1 || !city2) {
        alert("Indtast begge byer for at sammenligne.");
        return;
    }

    Promise.all([
        fetch(`api.php?city=${city1}`).then(res => res.text()),
        fetch(`api.php?city=${city2}`).then(res => res.text())
    ]).then(([data1, data2]) => {
        document.getElementById("weatherResult").innerHTML = `
            <section aria-label="Sammenlignede resultater">
                <article>${data1}</article>
                <article>${data2}</article>
            </section>
        `;
        document.getElementById("printBtn").hidden = false;
    }).catch(() => {
        document.getElementById("weatherResult").innerHTML = "Der opstod en fejl – prøv andre bynavne.";
        document.getElementById("printBtn").hidden = true;
    });
}

function showCompare() {
    document.getElementById("compareForm").style.display = "block";
    document.getElementById("singleSearchWrapper").style.display = "none"; // Skjul enkelt søgning
    document.getElementById("getWeatherBtn").style.display = "none";
    document.getElementById("toggleCompareBtn").style.display = "none";
    document.getElementById("backBtn").hidden = false;
    document.getElementById("printBtn").hidden = true;
}

function hideCompare() {
    document.getElementById("compareForm").style.display = "none";
    document.getElementById("singleSearchWrapper").style.display = "block"; // Vis enkelt søgning
    document.getElementById("getWeatherBtn").style.display = "inline-block";
    document.getElementById("toggleCompareBtn").style.display = "inline-block";
    document.getElementById("backBtn").hidden = true;
    document.getElementById("weatherResult").innerHTML = "";
    document.getElementById("printBtn").hidden = true;
}

function printWeather() {
    const content = document.getElementById("weatherResult").innerHTML;
    if (!content.trim()) {
        alert("Der er intet vejrdata at printe.");
        return;
    }
    const printWindow = window.open('', '', 'width=800,height=600');
    printWindow.document.write(`
        <html>
        <head>
            <title>Print vejr</title>
            <link rel="stylesheet" href="styles.css">
        </head>
        <body>
            <main>${content}</main>
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
}

function resetPage() {
    location.reload();
}
