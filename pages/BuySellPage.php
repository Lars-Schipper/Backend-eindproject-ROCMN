<?php
require_once('../scripts/dbh.inc.php');
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: ../pages/login.php");
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
$str = "SELECT `vrijeruimte` FROM `users` WHERE id = :id";
$stmt = $pdo->prepare($str);
$stmt->bindParam('id', $id);
$result = $stmt->execute();
$vrijeruimte;
while ($info = $stmt->fetch()) {
    $vrijeruimte = floatval($info['vrijeruimte']);
}

if (!empty($_POST["Handeling"])) {
    if ($_POST["Handeling"] == "Koop") {
        if ($_POST["totaalprijs"] < $vrijeruimte) {
            $aankoopPrijs = $_POST["totaalprijs"];
            $str = "INSERT INTO `aandelen_beheer` (`id`, `aandeelId`, `quantiteit`, `aankoopPrijs`) VALUES (:id, :aandeelId, :quantiteit, :aankoopPrijs)";
            $stmt = $pdo->prepare($str);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':aandeelId', $getTicker);
            $stmt->bindParam(':quantiteit', $_POST["aantal"]);
            $stmt->bindParam(':aankoopPrijs', $_POST["prijs"]);
            $stmt->execute();

            $vrijeruimte -= $aankoopPrijs;
            var_dump($vrijeruimte);
            $str = "UPDATE `users` SET `vrijeruimte` = :vrijeruimte  WHERE `id` = :id;";
            $stmt = $pdo->prepare($str);
            $stmt->bindParam(':vrijeruimte', $vrijeruimte);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            header("Location: ../pages/infopage.php?tickerId=" . $getTicker);
            exit;
        }
    } elseif ($_POST["Handeling"] == "Verkoop") {

        $str = "SELECT * FROM `aandelen_beheer` WHERE `id` = :id AND `aandeelId` = :aandeelId";
        $stmt = $pdo->prepare($str);
        $stmt->bindParam('id', $id);
        $stmt->bindParam('aandeelId', $getTicker);
        $result = $stmt->execute();

        $count = $_POST["aantal"];
        $aandelenInBezit = 0;

        if (array_key_exists($getTicker, $portfolio)) {
            foreach ($portfolio[$getTicker] as $key => $value) {
                $aandelenInBezit += $value["aantal"];
            }
            $i = 1;
            while ($beheer = $stmt->fetch()) {
                if ($count > $aandelenInBezit || $aandelenInBezit == 0) {
                    $i = 0;
                    break;
                }

                $transactieID = $beheer["transactieID"];
                if ($count > $beheer["quantiteit"]) {
                    $count -= $beheer["quantiteit"];
                    $stra = "DELETE FROM `aandelen_beheer` WHERE `aandelen_beheer`.`transactieID` = :transactieID";
                    $stmta = $pdo->prepare($stra);
                    $stmta->bindParam('transactieID', $transactieID);
                    $stmta->execute();
                } elseif ($count < $beheer["quantiteit"]) {
                    $temp = $beheer["quantiteit"] - $count;
                    $strb = "UPDATE `aandelen_beheer` SET `quantiteit` = :aantal WHERE `aandelen_beheer`.`transactieID` = :transactieID";
                    $stmtb = $pdo->prepare($strb);
                    $stmtb->bindParam('aantal', $temp);
                    $stmtb->bindParam('transactieID', $transactieID);
                    $stmtb->execute();
                    break;
                } elseif ($count == $beheer["quantiteit"]) {
                    $strb = "DELETE FROM `aandelen_beheer` WHERE `aandelen_beheer`.`transactieID` = :transactieID";
                    $stmtb = $pdo->prepare($strb);
                    $stmtb->bindParam('transactieID', $transactieID);
                    $stmtb->execute();
                    break;
                }
            }

            if ($i == 1) {
                $aankoopPrijs = $_POST["totaalprijs"];
                $vrijeruimte += $aankoopPrijs;
                $strc = "UPDATE `users` SET `vrijeruimte` = :vrijeruimte  WHERE `id` = :id;";
                $stmtc = $pdo->prepare($strc);
                $stmtc->bindParam(':vrijeruimte', $vrijeruimte);
                $stmtc->bindParam(':id', $id);
                $stmtc->execute();
                header("Location: ../pages/infopage.php?tickerId=" . $getTicker);
                exit;
            }
        }
    }
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
    <?php
    include './navbar.php';
    ?>
    <main>
        <div class="container">
            <div class="row text-center my-5">
                <div class="col">
                    <div class="card">
                        <div class="card-title">
                            <h3><?php echo $getTicker; ?></h3>
                            <h6>
                                <?php echo "vrijeruimte: €" . number_format($vrijeruimte, 2, ',', ' ') . "<br>";
                                $aantal = 0;
                                foreach ($portfolio as $key => $value) {
                                    if ($getTicker == $key) {
                                        foreach ($value as $k => $v) {
                                            $aantal += $v["aantal"];
                                        }
                                        echo "positie: " . $aantal;
                                    }
                                }; ?>
                            </h6>
                        </div>
                        <?php
                        if (isset($_POST["totaalprijs"]) && !isset($aandelenInBezit)) {
                            if (floatval($_POST["totaalprijs"]) > $vrijeruimte) {
                                echo '<div class="alert alert-danger">Geen saldo! wil je saldo bij boeken <a href="./bijboeken.php">klik hier</a></div>';
                            }
                        }
                        if (isset($aandelenInBezit)) {
                            if ($count > $aandelenInBezit) {
                                echo '<div class="alert alert-danger">Je hebt niet ' . $count . ' aandelen in bezit!</div>';
                            }
                        }

                        if (isset($_GET["actie"])) {
                            if ($_GET["actie"] == "koop") {
                                $handeling = "koop";
                            } elseif ($_GET["actie"] == "verkoop") {
                                $handeling = "verkoop";
                            }
                        } else {
                            $handeling = "null";
                        }
                        ?>

                        <div class="card-body">
                            <form action="BuySellPage.php?tickerId=<?php echo $getTicker; ?>" method="post">
                                <div class="row g-3 justify-content-center my-2">
                                    <div class="col-auto">
                                        <label for="Handeling">Handeling: </label>
                                    </div>
                                    <div class="col-auto">
                                        <select name="Handeling" id="Handeling" class="form-select" required>
                                            <option value="" <?php if ($handeling == "null") {
                                                                    echo "selected";
                                                                } ?>>Handeling</option>
                                            <option value="Koop" <?php if ($handeling == "koop") {
                                                                        echo "selected";
                                                                    } ?>>Koop</option>
                                            <option value="Verkoop" <?php if ($handeling == "verkoop") {
                                                                        echo "selected";
                                                                    } ?>>Verkoop</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row g-3 justify-content-center my-2">
                                    <div class="col-auto">
                                        <label for="prijs">Prijs: </label>
                                    </div>
                                    <div class="col-auto input-group" style="width: 150px;">
                                        <span class="input-group-text">€</span>
                                        <input id="prijs" name="prijs" class="form-control text-end" type="text" readonly>
                                    </div>
                                </div>

                                <div class="row g-3 justify-content-center my-2">
                                    <div class="col-auto">
                                        <label for="aantal">Aantal: </label>
                                    </div>
                                    <div class="col-auto">
                                        <input id="aantal" name="aantal" type="number" value="0" class="text-end form-control" style="width: 100px;" min="0">
                                    </div>
                                </div>

                                <div class="row g-3 justify-content-center my-2">
                                    <div class="col-auto">
                                        <label for="totaalprijs">Totaalprijs: </label>
                                    </div>
                                    <div class="col-auto input-group" style="width: 150px;">
                                        <span class="input-group-text">€</span>
                                        <input id="totaalprijs" name="totaalprijs" type="text" value="0.00" class="text-end form-control" readonly>
                                    </div>
                                </div>

                                <div class="row g-3 justify-content-center my-2">
                                    <div class="col-auto">
                                        <input type="submit" value="Plaats" class="btn btn-small btn-primary">
                                    </div>
                                </div>
                            </form>
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
            main
        } from "../scripts/buySellMain.js";
        let vrijeruimte = '<?php echo $vrijeruimte; ?>';
        let positie = '<?php echo $aantal; ?>';
        let ticker = '<?php echo $getTicker; ?>';
        main(vrijeruimte, positie, ticker);
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