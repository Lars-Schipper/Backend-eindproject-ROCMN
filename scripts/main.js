async function fetchStock() {
    return new Promise((resolve, reject) => {
        // fetch(`https://www.alphavantage.co/query?function=TOP_GAINERS_LOSERS&apikey=6661HLGHE00XWWSV`)
        fetch("./json/winnersLosers.json")
            .then(res => res.json())
            .then(data => {
                return resolve(data)
            })
            .catch(() => reject())
    })
}

async function fetchnews(ticker) {
    var requestOptions = {
        method: 'GET'
    };
    var params = {
        api_token: 'pmWu1KUVC19MyhtbezR16lTp21D0ZHu0RmySOEQa',
        symbols: ticker,
        limit: '3',
        language: 'en'
    };
    var esc = encodeURIComponent;
    var query = Object.keys(params)
        .map(function (k) { return esc(k) + '=' + esc(params[k]); })
        .join('&');
    return new Promise((resolve, reject) => {
        fetch("https://api.marketaux.com/v1/news/all?" + query, requestOptions)
            .then(response => response.json())
            .then(result => {
                return resolve(result);
            })
            .catch(() => reject());
    })
}

async function logtable() {
    let data = await fetchStock();
    data = data.most_actively_traded;
    let locatie = document.getElementById("winnerLosers");

    for (let i = 0; i < 11; i++) {
        let color;
        if (data[i].change_amount > 0) {
            color = "success";
        } else {
            color = "danger";
        }
        let row = document.createElement("tr");
        row.innerHTML = `
            <th scope="row"><a href="./pages/infopage.php?tickerId=${encodeURIComponent(data[i].ticker)}">${data[i].ticker}</a></th>
            <td>€${Intl.NumberFormat('nl-NL', { maximumSignificantDigits: 3 }).format(data[i].price)}</td>
            <td class="text-${color}">${data[i].change_percentage}</td>
        `;
        locatie.appendChild(row);
    }
}

async function logNews(ticker) {
    let news = await fetchnews(ticker);
    let locatie = document.getElementById("news");
    for (let i = 0; i < Object.keys(news.data).length; i++) {
        let card = document.createElement("div");
        card.classList.add("card");
        card.classList.add("mb-3");
        card.style.height = "150px";
        card.innerHTML = `
        <div class="row g-0">
            <div class="col-md-4">
                <img src="${news.data[i].image_url}" class="img-fluid rounded-start" alt="news_image" style="width: 180px; height: 150px;">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h6 class="card-title"><a href="${news.data[i].url}">${news.data[i].title}</a></h6>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                </div>
            </div>
        </div>`;
        locatie.appendChild(card);
    }
    document.querySelector("#spinner").style.display = "none";
}

function logtableWV(data, tabel) {
    let locatie;
    let color;
    if (tabel == "winners") {
        locatie = document.getElementById("Winners");
        color = "success";
    } else {
        locatie = document.getElementById("Losers");
        color = "danger";
    }

    for (let i = 0; i < 5; i++) {
        let row = document.createElement("tr");
        row.innerHTML = `
        <th scope="row"><a href="./pages/infopage.php?tickerId=${encodeURIComponent(data[i].ticker)}">${data[i].ticker}</a></th>
        <td>€${Intl.NumberFormat('nl-NL', { maximumSignificantDigits: 3 }).format(data[i].price)}</td>
        <td>€${Intl.NumberFormat('nl-NL', { maximumSignificantDigits: 3 }).format(data[i].change_amount)}</td>
        <td class="text-${color}">${data[i].change_percentage}</td>
        `;
        locatie.appendChild(row);
    }
}
let data = await fetchStock();
logtableWV(data.top_gainers, "winners");
logtableWV(data.top_losers, "losers");
let ticker = 'TSLA, AAPL, AMZN';
logNews(ticker);
ticker = 'AAP, NVDA, MSFT';
logNews(ticker);
logtable();