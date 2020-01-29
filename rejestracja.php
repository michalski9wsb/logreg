<?php
    session_start();
    if(isset($_POST['email']))
    {
        $wszystko_ok = true;

        $nick = $_POST['nick'];

        //sprawdzenie długości nicka
        if( (strlen($nick)<3) || (strlen($nick)>20) )
        {
            
            $wszystko_ok=false;
            $_SESSION['e_nick']="Nick musi posiadać od 3 do 20 znaków";
        } 
        if(ctype_alnum($nick)==false)
        {
            $wszystko_ok=false;
            $_SESSION['e_nick']="Nick może składać się tylko z liter i cyfr (bez polskich znaków)";

        }
        //sprawdź poprawność adresu email
        $email=$_POST['email'];
        $emailAfterSanitization=filter_var($email,FILTER_SANITIZE_EMAIL);
        if( (filter_var($emailAfterSanitization,FILTER_VALIDATE_EMAIL)==false) || ($emailAfterSanitization != $email))
        {
            $wszystko_ok=false;
            $_SESSION['e_email']="Podaj poprawny email";
        }

        //sprawdz poprawnosc hasla
        $haslo1 = $_POST['haslo1'];
        $haslo2 = $_POST['haslo2'];

        if( (strlen($haslo1)<8) || (strlen($haslo1>20)) ){
            $wszystko_ok=false;
            $_SESSION['e_haslo']="Hasło musi mieć od 8 do 20 znaków";
        }
        if($haslo1 != $haslo2)
        {
            $wszystko_ok=false;
            $_SESSION['e_haslo']="Podane hasła nie są identyczne";

        }
        $haslo_hash=password_hash($haslo1,PASSWORD_DEFAULT);
        
        //sprawdzamy checkbox
        if( !isset($_POST['regulamin']))
        {
            $wszystko_ok=false;
            $_SESSION['e_regulamin']="Należy zaakceptować regulamin";
        }
        //bot or not? Oto jest pytanie
        if( !isset($_POST['bot']) || ($_POST['bot']!=14))
        {
            $wszystko_ok=false;
            $_SESSION['e_bot']="Wyszło, że jesteś botem bo nie umiesz liczyć ;)";
        }
        //zapamiętaj wprowadzone dane
        $_SESSION['fr_nick']=$nick;
        $_SESSION['fr_email']=$email;
        $_SESSION['fr_haslo1']=$haslo1;
        $_SESSION['fr_haslo2']=$haslo2;
        if(isset($_POST['requlamin'])) $_SESSION['fr_regulamin']=true;

        // duplikaty email w bazie?
        require_once("connect.php");
        //informujemy php, że zamiast warrningów chcemy rzucać exceptions
        mysqli_report(MYSQLI_REPORT_STRICT);
        try{
            $polaczenie_db = new mysqli($host,$db_user,$db_pass,$db_name);
            if($polaczenie_db->connect_errno!=0)
            {
                throw new Exception(mysqli_connect_errno()); // rzuca nowy błąd
            }else
            {
                //czy email istnieje?
                $rezultat = $polaczenie_db->query("SELECT id FROM uzytkownicy WHERE email='$email'");
                if(!$rezultat) throw new Exception($polaczenie_db->error); // rzuć nowy wyjątek i wyświetli na ekranie error z nawiasu
                $ile_takich_email=$rezultat->num_rows;
                if($ile_takich_email>0)
                {
                    $wszystko_ok=false;
                    $_SESSION['e_email']="Istnieje już ten email";
                }

                //czy nick już istnieje?
                $rezultat=$polaczenie_db->query("SELECT id FROM uzytkownicy WHERE user='$nick'");

                if(!$rezultat) throw new Exception($polaczenie_db->error);

                $ile_takich_nikow=$rezultat->num_rows;
                if($ile_takich_nikow>0)
                {
                    $wszystko_ok=false;
                    $_SESSION['e_nick']="Istnieje już taki nick";
                }

                if($wszystko_ok==true)
                {
                    //Hurra! Wszystkie testy zaliczone, dodajemy gracza do bazy
                    if($polaczenie_db->query("INSERT INTO uzytkownicy VALUES (NULL,'$nick','$haslo_hash','$email',100,100,100,14)"))
                    {
                        $_SESSION['udanarejestracja']=true;
                        header('Location: witamy.php');
                    }else
                    {
                        throw new Exception($polaczenie_db->error);
                    }
                }

                $polaczenie_db->close();
            }

        }catch(Exception $e) //łapie błąd typu Exception jeśli jest
        {
            echo('<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności i prosimy o rejestrację w innym terminie!</span>');
            echo('<br/>Informacja developerska: '.$e);
        }

        



        
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
        <style>
            .error{
                color:red;
                margin:10px;
            }
        </style>
    </head>
    <body>
    <form method="post">
        <div><lable name="nick">Nickname:</lable><br /><input type="text" value="<?php
            if(isset($_SESSION['fr_nick']))
            {
                echo($_SESSION['fr_nick']);
                unset($_SESSION['fr_nick']);
            }
        ?>" name="nick" /></div>
        <?php
            if(isset($_SESSION['e_nick']))
            {
                echo('<div class="error">'.$_SESSION['e_nick'].'</div>');
                unset($_SESSION['e_nick']);
            }
            
        ?>
        <div><lable name="email">Email:</lable><br /><input type="text" value="<?php
            if(isset($_SESSION['fr_email']))
            {
                echo($_SESSION['fr_email']);
                unset($_SESSION['fr_email']);
            }
        ?>" name="email" /></div>
        <?php
            if(isset($_SESSION['e_email']))
            {
                echo('<div class="error">'.$_SESSION['e_email'].'</div>');
                unset($_SESSION['e_email']);
            }
            
        ?>
        <div><lable name="haslo1">Twoje hasło:</lable><br /><input type="password" value="<?php
            if(isset($_SESSION['fr_haslo1']))
            {
                echo($_SESSION['fr_haslo1']);
                unset($_SESSION['fr_haslo1']);
            }
        ?>" name="haslo1" /></div>
        <?php
            if(isset($_SESSION['e_haslo']))
            {
                echo('<div class="error">'.$_SESSION['e_haslo'].'</div>');
                unset($_SESSION['e_haslo']);
            }
        ?>
        <div><lable name="niek">Powtórz hasło:</lable><br /><input type="password" value="<?php
            if(isset($_SESSION['fr_haslo2']))
            {
                echo($_SESSION['fr_haslo2']);
                unset($_SESSION['fr_haslo2']);
            }
        ?>" name="haslo2" /></div>
        <div><lable name="bot">Działanie: 8+3*2</label><br /><input type="text" name="bot" /></div> <!-- 14 -->
        <?php
            if(isset($_SESSION['e_bot']))
            {
                echo('<div class="error">'.$_SESSION['e_bot'].'</div>');
                unset($_SESSION['e_bot']);
            }
        ?>
        <div><label><input type="checkbox" name="regulamin" <?php
            if(isset($_SESSION['fr_regulamin']))
            {
                echo("checked");
                unset($_SESSION['fr_regulamin']);
            }
        ?> />Akceptują regulamin</label></div>
        <?php
            if(isset($_SESSION['e_regulamin']))
            {
                echo('<div class="error">'.$_SESSION['e_regulamin'].'</div>');
                unset($_SESSION['e_regulamin']);
            }
        ?>
        <div><input type="submit" value="Zarejestruj się" /></div>
        
    </form>
    </body>
</html>