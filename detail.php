<?php
//session_start();
require 'header.php';

$id = $_GET['id'];

$sql = "SELECT * FROM teams WHERE id = :id";
$prepare = $pdo->prepare($sql);
$prepare->execute([
    ':id' => $id
]);
$team = $prepare->fetch(PDO::FETCH_ASSOC);

if (isset($_SESSION["loggedin"])&& $_SESSION["loggedin"]=== true){
    $sql = "SELECT * FROM users WHERE id = :id ";
    $prepare = $pdo->prepare($sql);
    $prepare->execute([
        ':id' => $_SESSION["id"]
    ]);
    $user = $prepare->fetch(PDO::FETCH_ASSOC);
    echo "welkom: {$user['username']}";

}
else{
    header("location: index.php");
}
//session_start();
//
//$sql = "SELECT * FROM teams WHERE id = :id";
//$prepare->execute([
//        ':id' => $id
//]);
//$teams = $prepare->fetchAll(PDO::FETCH_ASSOC);

if (isset($_SESSION["loggedin"])&& $_SESSION["loggedin"]=== true){
    $sql = "SELECT * FROM users WHERE id = :id";
    $prepare = $pdo->prepare($sql);
    $prepare->execute([
        ':id' => $_SESSION['id']
    ]);
    $user = $prepare->fetch(PDO::FETCH_ASSOC);
    echo "welkom: {$user['username']}";
}


$teamname = htmlentities($team['teamname']);
$teamleader = htmlentities($team['teamleader']);
$participants = htmlentities($team['participants']);
$creator = htmlentities($team['creator']);
?>


<div class="container">
    <h2><?=$teamname?></h2>
    <p>Leider:&nbsp;<?=$teamleader?></p>
    <p>Aantal spelers:&nbsp;<?=$participants?></p>

    <p>Maker: <?=$creator?></p>

    <form action="controller.php?id=<?=$id?>" method="post">
        <input type="hidden" name="type"  value="delete">
        <button class="delete-button" type="submit" value="delete-contact"> delete serie :) </button>
    </form>

    <a class="edit-link" href="edit.php?id=<?=$id?>">edit the Serie ;)</a>
</div>