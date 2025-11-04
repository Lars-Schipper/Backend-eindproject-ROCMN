export async function getAandelen(aandelen, vrijeruimte) {
    logVrijeruimte(vrijeruimte)
    createPieChart(aandelen);
    createCard(aandelen);
    let totaleinleg = getPortfolioWaarde(aandelen);
    let portfolioWaarde = await accountWaarde(aandelen, vrijeruimte);
    winstVerlies(totaleinleg, portfolioWaarde);
    dagWinstVerlies(aandelen, portfolioWaarde);
}

function getPortfolioWaarde(aandelen) {
    let totaalinleg = 0;
    for (const [key, val] of Object.entries(aandelen)) {
        val.forEach(element => {
            totaalinleg += (element.aantal * element.prijs);
        });
    }
    return totaalinleg;
}

async function accountWaarde(aandelen, vrijeruimte) {
    let totaleWaarde = 0;
    totaleWaarde += vrijeruimte;
    for (const [key, value] of Object.entries(aandelen)) {
        let aantal = 0;
        value.forEach(element => {
            aantal += element.aantal;
        })
        let prijs = 0;
        const data = await fetchdata(key);
        prijs = data
        totaleWaarde += aantal * prijs;
    };
    let accountWaarde = document.getElementById("accountwaarde");
    let portefuilleWaarde = document.getElementById("portefuilleWaarde");
    let span = document.createElement("span");
    let span2 = document.createElement("span");

    span.innerHTML = Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(totaleWaarde);
    accountWaarde.appendChild(span);

    span2.innerHTML = Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(totaleWaarde -= vrijeruimte);
    portefuilleWaarde.appendChild(span2);

    document.querySelector("#totalspinner0").style.display = "none";
    document.querySelector("#totalspinner1").style.display = "none";
    return totaleWaarde;
}

export async function fetchdata(key) {

    const url = `https://apistocks.p.rapidapi.com/intraday?symbol=${key}&interval=5min&maxreturn=200`;
    const options = {
        method: 'GET',
        headers: {
            'x-rapidapi-key': '7551abfd87mshb4ccf83ccafe7e0p1609dajsn0e980eaf521c',
            'x-rapidapi-host': 'apistocks.p.rapidapi.com'
        }
    };
    return new Promise((resolve, reject) => {
        fetch(url, options)
            .then(res => res.json())
            .then(data => {
                return resolve(data.Results.reverse()[0].Close)
            })
            .catch(() => reject())
    })
}

async function winstVerlies(totaleinleg, totaleWaarde) {
    let WV = totaleWaarde - totaleinleg;
    let percentage = WV * 100 / totaleinleg;
    let winst = document.getElementById("winstVerlies");
    let span = document.createElement("span");
    span.innerHTML = `${Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(WV)} (${percentage.toFixed(2)})`;

    if (WV > 0) {
        span.classList.add('text-success');
    } else {
        span.classList.add('text-danger');
    }
    winst.appendChild(span);
    document.querySelector("#totalspinner2").style.display = "none";
}

async function dagWinstVerlies(aandelen, totaalinleg) {
    let tablebody = document.getElementById("table");
    let dagWV = document.getElementById("dagWV");
    let wvPerDag = 0;
    document.querySelector("#totalspinner4").style.display = "none";
    for (const [key, value] of Object.entries(aandelen)) {
        let result = await fetchWV(key);
        let aantalAandelen = 0;

        for (const [index, nummer] of Object.entries(value)) {
            aantalAandelen += nummer.aantal;
        }

        let closeGisteren = result.Results[0].Close;
        let closeVandaag = result.Results[1].Close;
        let WVPerAandeel = closeGisteren - closeVandaag;
        let WVTotaal = WVPerAandeel * aantalAandelen;
        wvPerDag += WVTotaal;

        let tr = document.createElement("tr");
        let th = document.createElement("th");
        let tdHolding = document.createElement("td");
        let tdWVPerAandeel = document.createElement("td");
        let tdWVtotaal = document.createElement("td");

        th.scope = "row";
        th.textContent = key;
        tr.appendChild(th);

        tdHolding.textContent = aantalAandelen;
        tr.appendChild(tdHolding);
        tdWVPerAandeel.innerHTML = `${Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(WVPerAandeel)}`;
        tr.appendChild(tdWVPerAandeel);
        tdWVtotaal.innerHTML = `${Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(WVTotaal)}`;
        tr.appendChild(tdWVtotaal);
        tablebody.appendChild(tr);

        if (WVPerAandeel < 0) {
            tdWVPerAandeel.classList.add("text-danger");
        } else {
            tdWVPerAandeel.classList.add("text-success");
        }

        if (WVTotaal < 0) {
            tdWVtotaal.classList.add("text-danger");
        } else {
            tdWVtotaal.classList.add("text-success");
        }
    }
    let percentage = 100 / totaalinleg * wvPerDag;

    let WVdag = document.createElement("span");
    WVdag.innerHTML = `${Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(wvPerDag)} (${percentage.toFixed(2)})`;
    dagWV.appendChild(WVdag);
    document.querySelector("#totalspinner3").style.display = "none";

    if (wvPerDag > 0) {
        WVdag.classList.add("text-success");
    } else {
        WVdag.classList.add("text-danger");
    }
}

function fetchWV(key) {
    const d = new Date();
    d.getFullYear();
    let datumVandaag, datumgisteren;

    if (d.getDay() == 0) {
        datumVandaag = `${d.getFullYear()}-${d.getMonth()}-${d.getDate() - 2}`;
        datumgisteren = `${d.getFullYear()}-${d.getMonth()}-${d.getDate() - 3}`;
    } else if (d.getDay() == 6) {
        datumVandaag = `${d.getFullYear()}-${d.getMonth()}-${d.getDate() - 1}`;
        datumgisteren = `${d.getFullYear()}-${d.getMonth()}-${d.getDate() - 2}`;
    } else if (d.getDay() == 1) {
        datumVandaag = `${d.getFullYear()}-${d.getMonth()}-${d.getDate() - 3}`;
        datumgisteren = `${d.getFullYear()}-${d.getMonth()}-${d.getDate() - 4}`;
    } else if (d.getDay() == 2) {
        datumVandaag = `${d.getFullYear()}-${d.getMonth()}-${d.getDate() - 1}`;
        datumgisteren = `${d.getFullYear()}-${d.getMonth()}-${d.getDate() - 5}`;
    } else {
        datumVandaag = `${d.getFullYear()}-${d.getMonth()}-${d.getDate()-2}`;
        datumgisteren = `${d.getFullYear()}-${d.getMonth()}-${d.getDate() - 3}`;
    }
    const url = `https://apistocks.p.rapidapi.com/daily?symbol=${key}&dateStart=${datumgisteren}&dateEnd=${datumVandaag}`;
    const options = {
        method: 'GET',
        headers: {
            'x-rapidapi-key': '7551abfd87mshb4ccf83ccafe7e0p1609dajsn0e980eaf521c',
            'x-rapidapi-host': 'apistocks.p.rapidapi.com'
        }
    };
    return new Promise((resolve, reject) => {
        fetch(url, options)
            .then(res => res.json())
            .then(data => {
                return resolve(data);
            })
            .catch(() => reject())
    })
}

function logVrijeruimte(vrijeruimte) {
    let VR = document.getElementById('vrijeruimte');
    let span = document.createElement("span");
    span.innerHTML = `${Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(vrijeruimte)}`;
    VR.appendChild(span);
    return vrijeruimte;
}

function createPieChart(aandelen) {
    let dataP = [
    ]
    let i = 0;
    for (const [key, value] of Object.entries(aandelen)) {
        let totaleWaarde = 0;
        for (const [k, v] of Object.entries(value)) {
            totaleWaarde += v.aantal * v.prijs;
        }
        dataP[i] = { y: totaleWaarde, label: `${key}` };
        i++;
    }
    window.onload = function () {

        var chart = new CanvasJS.Chart("donut", {
            animationEnabled: true,
            data: [{
                type: "doughnut",
                startAngle: 60,
                indexLabelFontSize: 10,
                indexLabel: "{label} - #percent%",
                toolTipContent: "<b>{label}:</b> {y} (#percent%)",
                dataPoints: dataP,
            }]
        });
        chart.render();
    }
}

async function createCard(aandelen) {
    let portfolio = document.getElementById("portfolio")
    for (const [key, obj] of Object.entries(aandelen)) {
        let aantal = 0;
        let gemiddeldeprijs = 0;

        for (const [k, value] of Object.entries(obj)) {
            aantal += value.aantal;
            gemiddeldeprijs += (value.prijs * value.aantal);
        }
        let col = document.createElement("tr");

        gemiddeldeprijs = gemiddeldeprijs / aantal;

        let prijsPerAandeel = await fetchdata(key);
        col.innerHTML = `
            <th scope="col"><a href="../pages/infopage.php?tickerId=${key}">${key}</a></th>
            <td> ${aantal}</td>
            <td> ${Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(gemiddeldeprijs)}</td>
            <td> ${Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(prijsPerAandeel)}</td>
            <td> ${Intl.NumberFormat('nl-NL', { style: 'currency', currency: 'EUR' }).format(aantal * prijsPerAandeel)}</td>`;

        portfolio.appendChild(col);
    }
}