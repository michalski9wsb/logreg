<?php
    session_start();
    if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany']==trud)){
        header('Location: gra.php');
        exit(0);
    }
?>
<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8" />
        <title>Settlers</title>
        <meta name="description" content="opis" />
        <meta name="keywords" content="słowa, kluczowe" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    </head>
    <body>
        <h1><q>Tylko martwi ujżeli koniec wojny</q>- Platon</h1>
        <div><a href="rejestracja.php">Rejestracja - załóż darmowe konto</a>
        <form action="zaloguj.php" method="POST">
             <div class="forrow"><label>Login:</label><input type="text" name="login"/></div>
             <div class="forrow"><label>Hasło:</label><input type="password" name="haslo" /></div>
             <div class="forrow"><input type="submit" value="Zaloguj" /></div>
        </form>

        <?php
            if(isset($_SESSION['blad'])){
                echo $_SESSION['blad'];
            }
        ?>
    </body>
</html>