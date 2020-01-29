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
        <?php
            session_start();
            if(!isset($_SESSION['zalogowany']))
            {
                header('Location: index.php');
                exit(0);
            }
            echo("<p>Witaj ".$_SESSION['user'].'! <a href="logout.php">Wyloguj</a>');
            echo("<p><strong>Drewno:</strong> ".$_SESSION['drewno']." | <strong>Kamień:</strong> ".$_SESSION['kamien']." | "."<strong>Zboże:</strong> ".$_SESSION['zboze']."</p>");
            echo("<p><strong>E-mail</strong>: ".$_SESSION['email']);
            echo("<br /><strong>Dni premium:</strong> ".$_SESSION['dnipremium']);
        ?>
    </body>
</html>