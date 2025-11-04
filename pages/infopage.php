<?php

require_once('../scripts/dbh.inc.php');
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ./pages/login.php");
}
$getTicker = $_GET['tickerId'];
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

if (!empty($_POST["Handeling"])) {
    var_dump($_POST["Handeling"]);
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
    <script src="https://cdn.canvasjs.com/ga/canvasjs.min.js"></script>

</head>

<body>

    <?php
    include './navbar.php';
    ?>
    <main>
        <div class="container">
            <div class="row my-5">
                <div class="col">
                    <div class="card p-3 d-flex">
                        <div class="row">

                            <div class="col">
                                <div id="totalspinner0" class="spinner-border spinner-border-sm my-auto ms-1" role="status">
                                </div>
                                <h1 id="bedrijfsnaam"> </h1>
                                <h6 id="prijs"> </h6>
                            </div>


                            <div id="koopverkoop" class="col d-flex justify-content-end align-items-center">
                                <!-- <a href="../pages/BuySellPage.php" class="btn btn-outline-success m-3" style="height: 40px;">Koop</a>
                                <a href="../pages/BuySellPage.php" class="btn btn-outline-danger m-3" style="height: 40px;">Verkoop</a> -->
                            </div>

                        </div>

                        <div id="0" class="row">

                        </div>
                    </div>


                </div>
            </div>

            <div id="2" class="row my-5">
                <div class="col-12 col-md-6 mb-5">
                    <div class="card">
                        <div class="row">
                            <div class="col d-flex justify-content-center">
                                <div id="dag" class="btn btn-primary m-1" style="width: 100px;">1 dag</div>
                                <div id="week" class="btn btn-primary m-1" style="width: 100px;">1 week</div>
                                <div id="maand" class="btn btn-primary m-1" style="width: 100px;">1 maand</div>
                                <div id="jaar" class="btn btn-primary m-1" style="width: 100px;">1 jaar</div>
                            </div>
                        </div>

                        <div id="chartContainer" class="row" style="height: 300px; width: 100%;"></div>

                    </div>
                </div>

                <div class="col-12 col-md-6 mb-5">
                    <div id="informatie" class="card p-1">
                        <h3>Informatie</h3>


                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>

    </footer>

    <script type="module">
        import {
            main
        } from "../scripts/infopageMain.js";
        let ticker = '<?php echo $getTicker; ?>';
        let aandelen = '<?php echo json_encode($portfolio); ?>';
        aandelen = JSON.parse(aandelen);
        main(ticker, aandelen);
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