<?php
//session_start();

require 'header.php';

/*
 * dit is het scherm dat je ziet na je bent ingelogd.
 * ook moet je hier verschillende dingen zien zoals wedstrijden die spelen.
 * welke teams er zijn.
 * en een knop naar de admin page waar alleen de admin heen kan.
*/
//if ($_SERVER['REQUEST_METHOD'] !== 'POST' ) {
//    header('location: login.php');
//    exit;
//}

$sql = "SELECT * FROM teams";
$query = $pdo->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);

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
        <?php
            foreach ($teams as $team){
                $teamname = htmlentities($team['teamname']);

                echo "<li> <a class='teamnames' href='detail.php?id={$team ['id']}'>$teamname </a></li>";
            }
        ?>
    </div>
    <a href="addteam.php">Team Toevoegen!</a>

<?php require 'footer.php'; ?>