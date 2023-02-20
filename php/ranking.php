<?php
    require './components/connection.php';
    $query_str = 'SELECT users.user, users.hash, users.score FROM users ORDER BY users.score ASC;';
    $query = $conn -> query($query_str);
    $places = $query -> fetchAll();
    $i = 1;
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/main.js" defer></script>
</head>

<body>
    <a href="../index.php" class="back">Wróć</a>
    <div class="ranking">
        <h1>Ranking Hang<span>Ducks</span></h1>
        <?php foreach($places as $place): ?>
        <div class="place"><?php echo $i; $i++ ?>. <?= $place[0] . '#' .  $place[1]  . ' ' . $place[2] ?> </div>
        <?php endforeach; ?>        
    </div>
</body>

</html>