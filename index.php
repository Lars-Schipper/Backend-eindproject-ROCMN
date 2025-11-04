<?php

require_once('./scripts/dbh.inc.php');
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./pages/login.php");
}
?>

<!doctype html>
<html lang="en">

<head>
    <title>Main</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark d-flex">
            <div class="container-fluid flex-nowrap">
                <div class="container-fluid">
                    <a href="./index.php" class="navbar-bramd">
                        <img src="./pictures/logo.png" alt="logo" height="50">
                    </a>
                </div>
                <button type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" class="navbar-toggler"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse flex-row justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item ">
                        <a href="./index.php" class="nav-link">
                            Home
                        </a>
                    </li>
                    <li class="nav-item active">
                        <a href="./pages/portfolio.php" class="nav-link">
                            Porfolio
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            Account
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="./pages/gegevens.php" class="dropdown-item">Gegevens</a></li>
                            <li><a href="./scripts/logout.php" class="dropdown-item">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>


    <main>
        <div class="container">
            <div class="row text-center">
                <div class="col">
                    <h1>Welkom!</h1>
                    <p>Dit is mijn portfolio tracker!</p>
                </div>
            </div>

            <div class="row d-flex justify-content-center">
                <div class="col-11 col-lg-8 mb-5">
                    <div class="card p-2" style="height: 580px;">
                        <h3>
                            Nieuws:
                        </h3>
                        <div id="news" class="overflow-auto">
                            <div id="spinner" class="spinner-border spinner-border-sm my-auto ms-1" role="status">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-11 col-lg-4 mb-5">
                    <div class="card p-2" style="height: 580px;">
                        <div class="card-title">
                            <h3>
                                Populaire aandelen:
                            </h3>
                        </div>
                        <div class="overflow-auto">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <th scope="col">Ticker</th>
                                    <th scope="col">Prijs</th>
                                    <th scope="col">Percentage</th>
                                </thead>
                                <tbody id="winnerLosers">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="col-12 mb-5">
                        <div class="card p-2" style="min-width: 400px;">
                            <div class="card-title">
                                <h3>Winners & Losers: </h3>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="card p-1 m-0">
                                        <h5>Winners</h5>
                                        <div>
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Ticker</th>
                                                        <th scope="col">Prijs</th>
                                                        <th scope="col">Verandering</th>
                                                        <th scope="col">Percentage</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="Winners">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="card p-1 m-0">
                                        <h5>Losers</h5>
                                        <div>
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Ticker</th>
                                                        <th scope="col">Prijs</th>
                                                        <th scope="col">Verandering</th>
                                                        <th scope="col">Percentage</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="Losers">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>

    </footer>

    <script src="./scripts/main.js" type="module"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>