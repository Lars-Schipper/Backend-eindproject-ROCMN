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
</head>

<body>
    <?php
        include './navbar.php';
    ?>


    <main>
        <div class="container">
            <div class="row my-5">
                <div class="col">
                    <div class="card p-5">
                        <?php
                        $id = $_SESSION["id"];
                        $str = "SELECT * FROM users WHERE id = :id";
                        $stmt = $pdo->prepare($str);
                        $stmt->bindParam('id', $id);
                        $result = $stmt->execute();
                        $info = $stmt->fetch();
                        ?>
                        <h6>Gegevens: </h6>
                        <p>-voornaam: <?php echo $info["voornaam"]; ?></p>
                        <p>-achternaam: <?php echo $info["achternaam"] ?></p>
                        <p>-email: <?php echo $info["email"] ?></p>
                        <p>-telefoon nummer: <?php echo $info["telefoonNummer"] ?></p>
                        <p>-postcode: <?php echo $info["postcode"] ?></p>
                        <p>-woonplaats: <?php echo $info["woonplaats"] ?></p>
                        <p>-straatnaam: <?php echo $info["straatnaam"] ?></p>
                        <p>-huisnummer: <?php echo $info["huisnummer"] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>

    </footer>

    <script src="scripts/main.js" type="module"></script>

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