import { fetchdata } from "../scripts/portfolio.js";

export async function main(vrijeruimte, positie, ticker) {
    let prijs = document.getElementById("prijs");
    let aantal = document.getElementById("aantal");
    let totaalprijs = document.getElementById("totaalprijs");

    let data = await fetchdata(ticker);
    totaalprijs.value = `${(data * aantal.value).toFixed(2)}`;

    prijs.value = `${(data).toFixed(2)}`;

    aantal.addEventListener("change", () => {
        totaalprijs.value = `${(data * aantal.value).toFixed(2)}`;
    });
}




