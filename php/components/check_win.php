<?php 
     if ($_SESSION['lifes'] <= 0){
        $_SESSION['status'] = 1;
    }
    if (mb_strtoupper($_SESSION['word'][0], 'UTF-8') == mb_convert_encoding($_SESSION['enteredWord'], 'UTF-8', 'UTF-8'))
    {
        $_SESSION['status'] = 2;
    }
?>