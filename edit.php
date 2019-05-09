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

$teamname = htmlentities($team ['teamname']);
$teamleader = htmlentities($team ['teamleader']);
$participants = htmlentities($team ['participants']);

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

?>

<div class="container">

    <form action="controller.php" method="post">
        <input type="hidden" name="type" value="edit">


        <input type="text" name="teamname" id="teamname" value="<?=$teamname?>" placeholder="Team Naam">

        <input type="text" name="teamleader" id="teamleader" value="<?=$teamleader?>" placeholder="Team Leider">

        <input type="text" name="participants" id="participants" value="<?=$participants?>" placeholder="Aantal Spelers">

        <button type="submit"> update </button>

    </form>

</div>

