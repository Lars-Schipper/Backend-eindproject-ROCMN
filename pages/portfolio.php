<?php

require_once('../scripts/dbh.inc.php');
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../pages/login.php");
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.0.1/dist/chart.umd.min.js">
    </script>
    <script src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body>
    <?php

    include './navbar.php';
    
    $id = $_SESSION["id"];
    $str = "SELECT * FROM aandelen_beheer WHERE id = :id";
    $stmt = $pdo->prepare($str);
    $stmt->bindParam('id', $id);
    $result = $stmt->execute();
    $portfolio = [];
    while ($info = $stmt->fetch()) {
        if (!array_key_exists($info["aandeelId"], $portfolio)) {
            $portfolio[$info["aandeelId"]] = (([["aantal" => $info["quantiteit"], "prijs" => $info["aankoopPrijs"]]]));
        } else if (array_key_exists($info["aandeelId"], $portfolio)) {
            array_push($portfolio[$info["aandeelId"]], ["aantal" => $info["quantiteit"], "prijs" => $info["aankoopPrijs"]]);
        }
    }
    $str = "SELECT `vrijeruimte` FROM `users` WHERE id = :id";
    $stmt = $pdo->prepare($str);
    $stmt->bindParam('id', $id);
    $result = $stmt->execute();
    $vrijeruimte;
    while ($info = $stmt->fetch()) {
        $vrijeruimte = $info['vrijeruimte'];
    }
    ?>

    <main>
        <div class="container">
            <div class="row my-5">
                <div class="col">
                    <div class="card p-3">
                        <div class="row">
                            <div id="accountval" class="col-md-6 col-sm-12">
                                <h4>portfolio:</h4>
                                <div class="d-flex mb-3">
                                    <p id="accountwaarde" class="mb-0">
                                        totale account waarde:
                                    </p>
                                    <div id="totalspinner0" class="spinner-border spinner-border-sm my-auto ms-1" role="status">
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <p id="portefuilleWaarde" class="mb-0">
                                        portefuille waarde:
                                    </p>
                                    <div id="totalspinner1" class="spinner-border spinner-border-sm my-auto ms-1" role="status">
                                    </div>
                                </div>

                                <div class="d-flex mb-3">
                                    <p id="winstVerlies" class="mb-0">
                                        W/V:
                                    </p>
                                    <div id="totalspinner2" class="spinner-border spinner-border-sm my-auto ms-1" role="status">
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <p id="dagWV" class="mb-0">
                                        Dag w/v:
                                    </p>
                                    <div id="totalspinner3" class="spinner-border spinner-border-sm my-auto ms-1" role="status">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col d-flex text-nowrap">
                                        <p id="vrijeruimte">Vrijeruimte: </p>
                                    </div>

                                    <div class="col text-end">
                                        <i id="info" class="bi bi-info-circle btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"></i>
                                        <div class="collapse" id="collapseExample">
                                            <div class="card card-body text-center">
                                                <h6>Geld bijboeken?</h6>
                                                <a id="geldBijBoeken" href="./bijboeken.php" class="btn btn-primary btn-sm">klik hier!</a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 text-center">
                                <table class="table">
                                    <thead>
                                        <th scope="col">Aandeel</th>
                                        <th scope="col">Holding</th>
                                        <th scope="col">GAK</th>
                                        <th scope="col">Huidigeprijs</th>
                                        <th scope="col">positie</th>
                                    </thead>
                                    <tbody id="portfolio">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-12 mb-5">
                    <div id="dagWV" class="card p-3">
                        <h4>Dag W/V per aandeel: </h4>
                        <table class="table">
                            <thead>
                                <th scope="col">Aandeel</th>
                                <th scope="col">holding</th>
                                <th scope="col">WV / aandeel</th>
                                <th scope="col">WV / totaal</th>
                            </thead>
                            <tbody id="table" class="table table-hover">
                            </tbody>
                        </table>
                        <div id="totalspinner4" class="spinner-border spinner-border-sm my-auto ms-1" role="status">
                                </div>
                    </div>
                </div>
                <div class="col-md-6 col-12 mb-5">
                    <div class="card p-3" style="height: 60vh;">
                        <div class="card-title">
                            <h3>spreiding:</h3>
                        </div>
                        <div class="card-body" id="donut">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>

    </footer>

    <script type="module">
        import {
            getAandelen
        } from "../scripts/portfolio.js";
        let aandelen = '<?php echo json_encode($portfolio) ?>';
        let vrijeruimte = '<?php echo json_encode($vrijeruimte) ?>';
        aandelen = JSON.parse(aandelen);
        getAandelen(aandelen, parseInt(vrijeruimte));
    </script>
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