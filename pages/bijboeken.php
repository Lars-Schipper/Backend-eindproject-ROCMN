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
        include "./bijboeken.php";
    ?>

    <main>
        <div class="container text-center">
            <h1 class="mt-5">Bij boeken!</h1>
            <div class="row my-5">
                <div class="col">

                    <div class="card">
                        <form action="bijboeken.php" method="post">
                            <div class="my-3">
                                <label for="bedrag" class="form-label">bedrag:</label>
                                <input type="number" class="form-contrl" name="bedrag" id="bedrag" placeholder="bedrag in euro's" min="0">
                            </div>

                            <div class="mb-3">
                                <input type="submit" value="storten" class="from-control btn btn-primary">
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <?php
    $id = $_SESSION["id"];
    $str = "SELECT `vrijeruimte` FROM `users` WHERE id = :id";
    $stmt = $pdo->prepare($str);
    $stmt->bindParam('id', $id);
    $result = $stmt->execute();
    $vrijeruimte;
    while ($info = $stmt->fetch()) {
        $vrijeruimte = intval($info['vrijeruimte']);
    }

    if (!empty($_POST)) {
        $bedrag = intval($_POST['bedrag']);
        $vrijeruimte += $bedrag;
        try {
            $str = "UPDATE `users` SET `vrijeruimte` = :vrijeruimte WHERE `users`.`id` =:id";
            $stmt = $pdo->prepare($str);
            $stmt->bindParam('vrijeruimte', $vrijeruimte);
            $stmt->bindParam('id', $id);
            $result = $stmt->execute();
        } catch (Exception $err) {
            echo $err;
        }
    }
    ?>

    <footer>

    </footer>

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