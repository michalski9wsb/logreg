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
            if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
            {
                header('Location: index.php');
                exit(0);
            }
            require_once("connect.php");

            //otwarcie połączenia z bazą
            $polaczenie_db = new mysqli($host,$db_user,$db_pass,$db_name);

            if($polaczenie_db->connect_errno!=0)
            {
                echo("Error:".$polaczenie_db->connect_errno." Opis: ".$polaczenie_db->connect_error);
            }else{
                 $login = $_POST['login'];
                 $haslo = $_POST['haslo'];

                 $login = htmlentities($login,ENT_QUOTES,"UTF-8");
                 
              
                
                if($rezultat = $polaczenie_db->query(sprintf("SELECT * FROM uzytkownicy WHERE USER='%s'",
                mysqli_real_escape_string($polaczenie_db,$login)))){
                    $ile_userow = $rezultat->num_rows;
                    if($ile_userow>0)
                    {
                        $wiersz = $rezultat->fetch_assoc();
                        if(password_verify($haslo,$wiersz['pass'])==true)
                        {
                            $_SESSION['zalogowany']=true;
                            
                            $_SESSION['id_zalogowanego']=$wiersz['id'];
                            $_SESSION['user'] = $wiersz['user'];
                            $_SESSION['drewno']=$wiersz['drewno'];
                            $_SESSION['kamien']=$wiersz['zboze'];
                            $_SESSION['zboze']=$wiersz['zboze'];
                            $_SESSION['dnipremium']=$wiersz['dnipremium'];
                            $_SESSION['email']=$wiersz['email'];
                        
                            unset($_SESSION['blad']);
                            header('Location: gra.php');
                            $rezultat->free();
                        }else
                        {
                            $_SESSION['blad']='<span style="color:red;">Nie tak miało być! Nie ma Cię u Nas, ić się zarejestruj!</span>';
                            header('Location: index.php');
                        }
                    }else{
                        $_SESSION['blad']='<span style="color:red;">Nie tak miało być! Nie ma Cie u Nas, ić się zarejestruj!</span>';
                        header('Location: index.php');
                    }
                    
                }
                $polaczenie_db->close();
            }
           
        ?>
    </body>
</html>