<?php
session_start();
mb_internal_encoding('UTF-8'); 

if (!isset($_SESSION['startTime'])) {
    $_SESSION['startTime'] = time();
}

if (isset($_SESSION['status']) && $_SESSION['status'] == 2) {
    $_SESSION['finishTime'] = time() - $_SESSION['startTime'];
    $seconds = $_SESSION['finishTime'];
    $time = gmdate("H:i:s", $seconds);
} else {
    $_SESSION['finishTime'] = 0;
}

$name = $_POST['name'] ?? NULL;
if ($name){
    $_SESSION['name'] = $name;
}

$level = $_POST['level'] ?? NULL;
if ($level) {
    $_SESSION['level'] = $level;
}

if (isset($_SESSION['status'])){
    if ($_SESSION['status'] == 2){
            $hash = '';
            for ($i = 0; $i < 4; $i++){
                $hash .= rand(0, 4);
            }
            $fullName = $_SESSION['name'] . '#' . $hash;
        
            require './components/connection.php';
            try{
                $query_str = "INSERT INTO `users` (`hash`, `user`, `score`) VALUES ('{$hash}', '{$_SESSION['name']}', '{$time}')
                "        ;
                        $query = $conn -> query($query_str);
            }
            catch (PDOException $e){
                header("Location: ../index.php");
            }
    }
}

$displayInput = false;
if (!isset($_SESSION['name']) && !isset($_SESSION['level'])){
    $displayInput = true;
}else{
    if (!isset($_SESSION['lifes'])){
        $_SESSION['lifes'] = 3;
    }

    if (!isset($_SESSION['word'])){
        require './components/connection.php';
        $query_str = "SELECT words.word, words.category_fk
                        FROM words
                    WHERE words.level = '{$level}' ORDER BY rand() LIMIT 1";
        $query = $conn -> query($query_str);
        $_SESSION['word'] = $query -> fetch();
    }

    if (!isset($_SESSION['enteredWord'])){
        $_SESSION['enteredWord'] = '';
        for($i = 0; $i < mb_strlen($_SESSION['word'][0]); $i++){
            $_SESSION['enteredWord'] .= '-';
        }
    }

    if (!isset($_SESSION['wellUsedLetters'])){
        $_SESSION['wellUsedLetters'] = '';
    }
    if (!isset($_SESSION['wrongUsedLetters'])){
        $_SESSION['wrongUsedLetters'] = '';
    }
    if (!isset($_SESSION['dead'])){
        $_SESSION['dead'] = false;
    }
    if (!isset($_SESSION['status'])){
        $_SESSION['status'] = 0; /* 0 - gra, 1- przegrana, 2 - wygrana */
    }
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js" defer></script>
</head>

<body>
    <?php if ($displayInput): ?>
    <div class="container">
        <h1>Hang<span>Ducks</span></h1>
        <form method="POST">
            <input type="text" name = "name" placeholder="Nazwa użytkownika" required>
            <select name="level" required>
                <option value="">Poziom trudności</option>
                <option value="easy">Łatwy</option>
                <option value="normal">Normalny</option>
                <option value="hard">Trudny</option>
            </select>
            <button type="submit" class="btn">Graj</button>
        </form>
    </div>
    <?php else: ?>
    <a href="../index.php" class="back">Wróć</a>
    <a href="./reset.php" class="reset">Zrestartuj</a>
    <div class="game">
        <h1>Hang<span>Ducks</span></h1>
        <div class="window">
            <?php if ($_SESSION['lifes'] == 3 && !$_SESSION['dead']): ?>
            <img src="../img/ducks/0from3dance.gif" alt="">
            <?php elseif ($_SESSION['lifes'] == 2 && !$_SESSION['dead']): ?>
            <img src="../img/ducks/1from3dance.gif" alt="">
            <?php elseif ($_SESSION['lifes'] == 1 && !$_SESSION['dead']): ?>
            <img src="../img/ducks/2from3dance.gif" alt="">
            <?php endif; ?>
            <?php if ($_SESSION['lifes'] == 2 && $_SESSION['dead']): ?>
            <img src="../img/ducks/1from3dead.gif" alt="">
            <?php elseif ($_SESSION['lifes'] == 1 && $_SESSION['dead']): ?>
            <img src="../img/ducks/2from3dead.gif" alt="">
            <?php elseif ($_SESSION['lifes'] == 0 && $_SESSION['dead']): ?>
            <img src="../img/ducks/game_over.gif" alt="">
            <?php endif; ?>
            
        </div>
                <?php if ($_SESSION['status'] == 2): ?>
                <p class = "label" >Twój nick w rankingu: <?= $fullName ?></p>
                <p class = "label" >Twój czas: <?= $time ?></p>
                <?php endif; ?>
                <p class="status label">
                    <?php if ($_SESSION['status'] == 1): ?>
                    Przegrałeś!
                        <?php elseif ($_SESSION['status'] == 2): ?>
                    Wygrałeś!
                        <?php elseif ($_SESSION['status'] == 0): ?>
                            Gra trwa!
                        <?php endif; ?>
                </p>
        <p class="lifes label">
        <?php for ($i = 0; $i < $_SESSION['lifes']; $i++):?>
         <i class="ti ti-heart-filled"></i>
        <?php endfor; ?>
    </p>
        <p class="category label">Kategoria: <span><?= $_SESSION['word'][1] ?></span></p>
        <div class="fields">
            <p class="label">Słowo: </p>
            <div class="box">
            <?php if (!$_SESSION['status'] == 1):?>
               <?php for ($i = 0; $i < mb_strlen($_SESSION['enteredWord']); $i++): ?>
                <div class="field"><?= $_SESSION['enteredWord'][$i] ?></div>
                <?php endfor; ?>
             <?php else: ?>
                <p class = "label"><?= $_SESSION['word'][0] ?></p>
            <?php endif;?>
        </div>
        </div>
        <?php if ($_SESSION['status'] == 0): ?>
        <form method="POST" action = "./components/check_letter.php">
            <input type="text" name="letter" maxlength="1" placeholder="Wprowadź litere.." required>
            <button type="submit" class="btn">Zgadnij</button>
        </form>
            <?php else: ?>
                <form action="">
                    <a href="./reset.php" class="btn">Od nowa</a>
                </form>
            <?php endif; ?>
        <?php if ($_SESSION['wellUsedLetters'] || $_SESSION['wrongUsedLetters']): ?>
            <div class="used-letters">
                <p class="label">Historia wprowadzonych liter: </p>
                    <div class="box">
                        <?php for ($i = 0; $i < mb_strlen($_SESSION['wellUsedLetters']); $i++): ?>
                            <p class="field well"><?= $_SESSION['wellUsedLetters'][$i] ?></p>
                        <?php endfor; ?>
                        <?php for ($i = 0; $i < mb_strlen($_SESSION['wrongUsedLetters']); $i++): ?>
                            <p class="field wrong"><?= $_SESSION['wrongUsedLetters'][$i] ?></p>
                        <?php endfor; ?>
                    </div>
            </div>
        <?php endif; ?>
    <?php  endif; ?>
</body>

</html>