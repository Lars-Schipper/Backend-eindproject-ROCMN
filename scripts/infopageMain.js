import { fetchdata } from "../scripts/portfolio.js";

export async function main(ticker, aandelen) {
    loginfo(ticker);
    koopVerkoopKnop(ticker);
    logPositie(ticker, aandelen);
}

function koopVerkoopKnop(ticker) {
    let plek = document.getElementById("koopverkoop");
    let koop = document.createElement("a");
    let verkoop = document.createElement("a");

    koop.href = `../pages/BuySellPage.php?tickerId=${ticker}&actie=koop`;
    verkoop.href = `../pages/BuySellPage.php?tickerId=${ticker}&actie=verkoop`;
    koop.classList.add("btn");
    koop.classList.add("btn-outline-success");
    koop.classList.add("m-3");
    verkoop.classList.add("btn");
    verkoop.classList.add("btn-outline-danger");
    verkoop.classList.add("m-3");
    koop.style.height = "40px";
    verkoop.style.height = "40px";
    koop.textContent = `Koop`;
    verkoop.textContent = `Verkoop`;

    plek.appendChild(koop);
    plek.appendChild(verkoop);
}

async function loginfo(ticker) {
    let info = await fetchinfo(ticker);
    lognaam(info, ticker);
    logBedrijfsData(info);
    grafiek(ticker);
}

async function lognaam(info, ticker) {
    let data = await fetchdata(ticker);

    let naam = document.getElementById("bedrijfsnaam");
    let prijs = document.getElementById("prijs");

    let temp = data;
    document.querySelector("#totalspinner0").style.display = "none";
    naam.textContent = info.results.name;
    prijs.innerHTML = Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(temp);

    let card = document.getElementById("koopverkoop");
    let koop = document.createElement("div")
}

async function grafiek(ticker) {
    let eenheid = `dag`;

    let dag = document.getElementById("dag");
    let week = document.getElementById("week");
    let maand = document.getElementById("maand");
    let jaar = document.getElementById("jaar");

    dag.addEventListener("click", () => {
        eenheid = `dag`;
        fetchDataForGraph(ticker, eenheid);
    });

    week.addEventListener("click", () => {
        eenheid = `week`;
        fetchDataForGraph(ticker, eenheid);
    });

    maand.addEventListener("click", () => {
        eenheid = `maand`;
        fetchDataForGraph(ticker, eenheid);
    });

    jaar.addEventListener("click", () => {
        eenheid = `jaar`;
        fetchDataForGraph(ticker, eenheid);
    });

    fetchDataForGraph(ticker, eenheid);
}

function logBedrijfsData(info) {
    let naam = info.results.name
    let ticker = info.results.ticker
    let exchange = info.results.primary_exchange
    let link = info.results.homepage_url
    let adress = info.results.address
    let land = info.results.locale
    let phonenumber = info.results.phone_number
    let omschrijving = info.results.description
    let informatie = document.getElementById("informatie");
    let div1 = document.createElement("div");
    let div2 = document.createElement("div");
    let div3 = document.createElement("div");
    let div4 = document.createElement("a");
    let div5 = document.createElement("div");
    let div6 = document.createElement("div");
    let div7 = document.createElement("div");

    div1.textContent = `Naam: ${naam}`;
    div2.textContent = `Ticker ${ticker}`;
    div3.textContent = `Exchange: ${exchange}`;
    div4.textContent = `${link}`;
    div4.href = link;
    try {
        div5.textContent = `Adress: ${adress.address1}, ${adress.city}, ${adress.state}, ${land.toUpperCase()}`;
    } catch (error) {
        div5.textContent = `Adress: Unkown`;
    }
    div5.classList.add("mt-3");
    div6.textContent = `Tel: ${phonenumber}`;
    div7.textContent = omschrijving;
    div7.classList.add("mt-3");

    informatie.appendChild(div1);
    informatie.appendChild(div2);
    informatie.appendChild(div3);
    informatie.appendChild(div4);
    informatie.appendChild(div5);
    informatie.appendChild(div6);
    informatie.appendChild(div7);
}

async function fetchinfo(ticker) {
    return new Promise((resolve, reject) => {
        fetch(`https://api.polygon.io/v3/reference/tickers/${ticker}?apiKey=otqiRjNycnXK2N4KZdHIHoF8bgxHBXEd`)
            .then(res => res.json())
            .then(data => {
                return resolve(data)
            })
            .catch(() => reject())
    })
}

async function fetchDataForGraph(ticker, eenheid) {
    let url;
    switch (eenheid) {
        case `dag`:
            url = `https://apistocks.p.rapidapi.com/intraday?symbol=${ticker}&interval=5min&maxreturn=100`;
            break;

        case `week`:
            url = `https://apistocks.p.rapidapi.com/daily?symbol=${ticker}&dateStart=2024-07-01&dateEnd=2024-07-08`;
            break;

        case `maand`:
            url = `https://apistocks.p.rapidapi.com/weekly?symbol=${ticker}&dateStart=2023-06-01&dateEnd=2023-06-31`;
            break;

        case `jaar`:
            url = `https://apistocks.p.rapidapi.com/monthly?symbol=${ticker}&dateStart=2023-01-01&dateEnd=2023-12-31`;
            break;
        default:
            break;
    }

    const options = {
        method: 'GET',
        headers: {
            'x-rapidapi-key': '7551abfd87mshb4ccf83ccafe7e0p1609dajsn0e980eaf521c',
            'x-rapidapi-host': 'apistocks.p.rapidapi.com'
        }
    };

    fetch(url, options)
        .then(res => res.json())
        .then(data => {
            let dataPoints = [];
            let i = 0;
            data.Results.forEach(element => {
                dataPoints[i] = { y: element.Close };
                i++;
            });
            plotgrafiek(dataPoints);
        })
        .catch()
}

function plotgrafiek(dataP) {
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        data: [{
            type: "line",
            indexLabelFontSize: 16,
            dataPoints: dataP,
        }]
    });
    chart.render();
}

async function logPositie(ticker, aandelen) {
    for (const [symbol, positie] of Object.entries(aandelen)) {
        let pos = document.getElementById("0");
        if (symbol == ticker) {
            let count = 0;
            for (const [key, value] of Object.entries(positie)) {
                count += value.aantal;
            }
            let data = await fetchdata(ticker);
            let prijs = data;
            let temp = Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(count * prijs);
            let col = document.createElement("div");
            col.textContent = `positie: ${temp} (St.${count})`;
            pos.appendChild(col);
        }
    }
}