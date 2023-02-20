<?php 
session_start();
$letter = $_POST['letter'] ?? NULL;
if (!$letter){
    header("Location: ../../index.php");
}
if (str_contains($_SESSION['wellUsedLetters'], $letter) || str_contains($_SESSION['wrongUsedLetters'], $letter)){
    header("Location: ../game.php");
    exit();
}

$_SESSION['dead'] = false;

$str = mb_strtoupper($_SESSION['word'][0], 'UTF-8');

$find = mb_strtoupper($_POST['letter'], 'UTF-8');
$str = mb_strtoupper($_SESSION['word'][0], 'UTF-8');
$find = mb_convert_encoding($find, 'UTF-8');
$str = mb_convert_encoding($str, 'UTF-8');

$positions = array();

$pos = mb_strpos($str, $find);
while ($pos !== false) {
    $positions[] = $pos;
    $pos = mb_strpos($str, $find, $pos + 1);
}

if ($positions){
    foreach($positions as $pos){
        $_SESSION['enteredWord'][$pos] = $find;
    }
    $_SESSION['wellUsedLetters'] .= $find;
}else{
    $_SESSION['wrongUsedLetters'] .= $find;
    $_SESSION['lifes'] -= 1;
    $_SESSION['dead'] = true;
}

require './check_win.php';
header("Location: ../game.php");
?>