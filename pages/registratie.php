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
                    <h1>Registratie page</h1>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?php
                    if (!empty($_POST)) {
                        $voornaam = $_POST["voornaam"];
                        $achternaam = $_POST["achternaam"];
                        $gebruikesnaam = $_POST["gebruikersnaam"];
                        $email = $_POST["email"];
                        $wachtwoord = $_POST["wachtwoord"];
                        $passwordhash = password_hash($wachtwoord, PASSWORD_DEFAULT);
                        $telefoonnummer = intval($_POST["telefoonNummer"]);
                        $postcode = $_POST["postcode"];
                        $woonplaats = $_POST["woonplaats"];
                        $straatnaam = $_POST["straatnaam"];
                        $huisnummer = $_POST["huisnummer"];

                        try {
                            $str = "INSERT INTO `users`(`voornaam`, `achternaam`, `gebruiker`, `email`, `wachtwoord`, `telefoonNummer`, `postcode`, `woonplaats`, `straatnaam`, `huisnummer`) VALUES (:voornaam, :achternaam, :gebruikersnaam, :email , :wachtwoord, :telefoonNummer, :postcode, :woonplaats, :straatnaam, :huisnummer)";
                            $stmt = $pdo->prepare($str);
                            $stmt->bindParam(':voornaam', $voornaam);
                            $stmt->bindParam(':achternaam', $achternaam);
                            $stmt->bindParam(':gebruikersnaam', $gebruikesnaam);
                            $stmt->bindParam(':email', $email);
                            $stmt->bindParam(':wachtwoord', $passwordhash);
                            $stmt->bindParam(':telefoonNummer', $telefoonnummer);
                            $stmt->bindParam(':postcode', $postcode);
                            $stmt->bindParam(':woonplaats', $woonplaats);
                            $stmt->bindParam(':straatnaam', $straatnaam);
                            $stmt->bindParam(':huisnummer', $huisnummer);
                            $stmt->execute();

                            echo "<script>
                            alert('U bent succesvol geregistreed! U kunt inloggen.');
                            window.location.href='./login.php';
                            </script>";
                        } catch (Exception $err) {
                            echo $err;
                        }
                    }
                    ?>
                    <div class="row d-flex justify-content-center">
                        <div class="col-6">
                            <p>Zorg er voor dat u alle velden invult</p>

                            <div class="form my-5">
                                <form action="registratie.php" method="post">
                                    <label class="form-label" for="voornaam">voornaam: </label>
                                    <input class="form-control mb-3" type="text" name="voornaam" placeholder="Voornaam" required>

                                    <label class="form-label" for="achternaam">achternaam: </label>
                                    <input class="form-control mb-3" type="text" name="achternaam" placeholder="Achternaam" required>

                                    <label class="form-label" for="gebruikersnaam">gebruikersnaam: </label>
                                    <input class="form-control mb-3" type="text" name="gebruikersnaam" placeholder="Gebruikersnaam" required>

                                    <label class="form-label" for="email">email: </label>
                                    <input class="form-control mb-3" type="email" name="email" placeholder="Email" required>

                                    <label class="form-label" for="wachtwoord">wachtwoord: </label>
                                    <input class="form-control mb-3" type="password" name="wachtwoord" placeholder="Wachtwoord" required>

                                    <label class="form-label" for="telefoonNummer">telefoon nummer: </label>
                                    <input class="form-control mb-3" type="tel" name="telefoonNummer" placeholder="Telefoon nummer" required>

                                    <label class="form-label" for="postcode">postcode: </label>
                                    <input class="form-control mb-3" type="text" name="postcode" placeholder="Postcode" required>

                                    <label class="form-label" for="woonplaats">woonplaats: </label>
                                    <input class="form-control mb-3" type="text" name="woonplaats" placeholder="Woonplaats" required>

                                    <label class="form-label" for="straatnaam">straatnaam: </label>
                                    <input class="form-control mb-3" type="text" name="straatnaam" placeholder="Straatnaam" required>

                                    <label class="form-label" for="huisnummer">huisnummer: </label>
                                    <input class="form-control mb-5" type="text" name="huisnummer" placeholder="Huisnummer" required>

                                    <input class="btn btn-secondary" type="submit" value="Aanmelden!">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-5">
                <div class="col">
                    <p>Heeft u al een account?</p>
                    <a href="./login.php">log hier in!</a>
                </div>
            </div>
        </div>
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