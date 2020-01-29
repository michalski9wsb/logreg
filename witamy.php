<?php
    session_start();
    if(!isset($_SESSION['udanarejestracja']) ){
        header('Location: index.php');
        exit(0);
    }else
    {
        unset($_SESSION['udanarejestracja']);
    }
    // usuwamy zmienne pamiętające wartości wpisane do formularza 
    if(isset($_SESSION['fr_nick'])) unset($_SESSION['fr_nick']);
    if(isset($_SESSION['fr_email'])) unset($_SESSION['fr_email']);
    if(isset($_SESSION['fr_haslo1'])) unset($_SESSION['fr_haslo1']);
    if(isset($_SESSION['fr_haslo2'])) unset($_SESSION['fr_haslo2']);
    if(isset($_SESSION['fr_regulamin'])) unset($_SESSION['fr_regulamin']);

    //usuwanie błędów rejestracji
    if(isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
    if(isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
    if(isset($_SESSION['e_haslo'])) unset($_SESSION['e_haslo']);
    if(isset($_SESSION['e_regulamin'])) unset($_SESSION['e_regulamin']);
    if(isset($_SESSION['e_bot'])) unset($_SESSION['e_bot']);

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
        Dziękujemy za rejestrację w serwisie, możesz już zalogować się na swoje konto<br /><br />
        <div><a href="index.php">Zaloguj się na swoje konto</a>

    </body>
</html>