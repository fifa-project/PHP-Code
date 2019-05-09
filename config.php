<?php session_start();

//hier komt de connectie naar de database en een json query

$dbHost = "localhost";
$dbName = "fifa";
$dbUser = "root";
$dbPass = "";

$pdo = new PDO(
    "mysql:host=$dbHost;dbname=$dbName",
    $dbUser,
    $dbPass
);

$sql = "SELECT * FROM teams";
$query = $pdo->query($sql);

$teams = $query->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM users";
$query = $pdo->query($sql);

$users = $query->fetchAll(PDO::FETCH_ASSOC);
//error

try{
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    echo "<h1>OEi :(</h1> de connectie met de database is niet gelukt check je config.php";
    die($e->getMessage());
}
?>
