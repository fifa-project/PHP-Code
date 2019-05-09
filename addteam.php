<?php require 'header.php';

//session_start();
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
//hier kan je een team toevoegen als je ingelogd bent anders niet

?>

<div class="container">

    <form action="controller.php" method="post">
        <input type="hidden" name="type" value="addteam">


        <input type="text" name="teamname" id="teamname" placeholder="Team Naam">

        <input type="text" name="teamleader" id="teamleader" placeholder="Team Leider">

        <input type="text" name="participants" id="participants" placeholder="Aantal Spelers">

        <button type="submit"> Toevoegen </button>

    </form>

</div>











<?php
require 'footer.php';
?>