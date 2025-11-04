<?php

require_once('../scripts/dbh.inc.php');
?>


<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
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
        <!-- place navbar here -->
    </header>
    <main>
        <div class="container text-center my-5 border border-dark rounded">
            <div class="row my-5">
                <div class="col">
                    <h1>Login page</h1>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?php
                    if (!empty($_POST['username']) && !empty($_POST['wachtwoord'])) {
                        $username = $_POST['username'];
                        $password = $_POST['wachtwoord'];
                        $hash = password_hash($password, PASSWORD_DEFAULT);
                        $str = "SELECT * FROM users WHERE gebruiker= :gebuiker;";
                        $stmt = $pdo->prepare($str);
                        $stmt->bindParam('gebuiker', $username);
                        $result = $stmt->execute();

                        while ($credetnials = $stmt->fetch()) {
                            if (password_verify($password, $credetnials['wachtwoord'])) {
                                echo '<h1>Wachtwoord correct </h1>';
                                session_start();
                                session_name("loggedInUser");
                                $_SESSION['id'] = $credetnials['id'];
                                header("Location: ../index.php");
                                exit();
                            }
                        }
                        echo '<h3 class="text-danger">Gebruikersnaam of Wachtwoord incorrect<h3>';
                    }
                    ?>
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-6">
                        <div class="form my-5">
                            <form action="login.php" method="post">
                                <label class="form-label" for="username">gebruikersnaam: </label>
                                <input class="form-control" type="text" name="username" placeholder="Gebruikersnaam" required><br>

                                <label class="form-label" for="wachtwoord">wachtwoord: </label>
                                <input class="form-control" type="password" name="wachtwoord" placeholder="Wachtwoord" required><br>

                                <input class="btn btn-secondary" type="submit" value="login">
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col">
                    <p>Nog geen account?</p>
                    <a href="./registratie.php">Registreer hier!</a>
                </div>
            </div>
        </div>


</body>
</main>
<footer>
    <!-- place footer here -->
</footer>
<!-- Bootstrap JavaScript Libraries -->
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