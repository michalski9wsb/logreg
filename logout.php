<?php
    session_start();

    //niszczymy sesję!
    session_unset();
    header('Location: index.php');
?>
