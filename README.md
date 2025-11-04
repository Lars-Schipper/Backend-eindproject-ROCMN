Hallo!
Dit is mijn eindproject Backend!

Wat is mijn project?

Voor het eindproject zijn we helemaal vrijgelaten in wat voor een applicatie we wilden maken.
Ik heb ervoor gekozen om een brokerapplicatie te maken.
Het idee is tot mij gekomen omdat ik beleggen een erg interessant onderwerp vind.

In de applicatie kun je aandelen volgen en kopen/verkopen. Je kunt zien of de prijs stijgt/daalt.
Er is een deel met nieuws dat actuele nieuwsberichten weergeeft over bedrijven waarin je kunt beleggen.
Ook is het mogelijk om zelf aandelen te kopen en verkopen in de applicatie. Dit gebeurt met fictief geld.
De aandelen die je hebt gekocht, komen in je portfolio te staan. Je kunt je portfolio bekijken en zien welke aandelen je in bezit hebt.
Hier is ook te zien hoe elk aandeel is gestegen of gedaald, en hoeveel winst of verlies je portfolio al heeft gemaakt.

Maar voordat je dit allemaal kunt zien/doen, moet je natuurlijk eerst inloggen of een account aanmaken. Dit is natuurlijk ook allemaal mogelijk.

Wat ook belangrijk is om te weten, is dat er gebruik wordt gemaakt van API's.
Sommige API's zijn gratis, maar zijn wel gelimiteerd in het aantal calls dat mag worden gemaakt.
Zo mag de API die gebruikt wordt voor het nieuws maar 100x per dag worden aangeroepen.
Het zou dus kunnen dat tijdens het testen de API geen data meer terugstuurt.

Dit geldt ook voor de API die gebruikt wordt voor de Winners & Losers en de Populaire aandelen; deze mocht maar 15x per dag worden aangeroepen.
Ik heb bij deze API er dus ook voor gekozen om hier een .json-bestand voor te maken en deze uit te lezen.
Als je echt de API wilt aanroepen, moet je bij main.js regel 3 de // weghalen en deze bij regel 4 ervoor zetten.

Een functie die ik graag nog had willen toevoegen, was een zoekbalk. Dan had je bedrijven kunnen opzoeken en hier dan de data van kunnen zien.
Je kunt nu wel, als je op de info-pagina zit, de URL aanpassen door het tickerId te vervangen. Als je dit doet, kun je alle aandelen van de Amerikaanse beurs zien.

Wat heb je nodig om dit project te runnen?

1. Xampp
    - Download Xampp via de website: https://www.apachefriends.org
    - Volg de stappen op de website om dit te installeren.

2. VScode om de code te kunnen bekijken.
    - Download VScode via de website: https://code.visualstudio.com
    - Volg de stappen om dit te installeren.


3. PHP
    - In VScode kun je bij extensies de PHP Intelephense installeren.
    - Met PHP -v kun je in de commandline van VScode checken of PHP is geïnstalleerd.
    - Ik heb dit project gemaakt met PHP 8.1.29.

4. Node.js
    - Node.js kun je downloaden via deze link: https://nodejs.org/en/download/package-manager
    - Om te checken of Node.js correct is geïnstalleerd, kun je node -v uitvoeren in de commandline.

5. Database opzetten
    - Om de database op te zetten, is er een import.sql-bestand aangeleverd.
    - Start de Xampp-applicatie op en start de MYSQL-database op.
    - Ga in je browser naar http://localhost/phpmyadmin/index.php.
    - Ga naar SQL (boven in de navigatiebalk).
    - Copy-paste het import.sql-bestand (te vinden in de scriptsmap) in het queryveld en voer deze uit door op Start te drukken.
    - Download mijn project en zet deze in de htdocs-map van de Xampp-applicatie.

6. Project toegang geven tot database
    - Open phpMyAdmin.
    - Ga naar gebruikersaccount (boven in de navigatiebalk).
    - Voeg een nieuwe gebruiker toe aan de database.
    - Maak voor deze gebruiker de username en het password: "bit_academy". Voor de hostname voer je "localhost" in.
    - Zorg ook dat de gebruiker alle global privileges krijgt.# Backend-eindproject-ROCMN
