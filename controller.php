<?php
require 'config.php';
/*alle control punten voor de forms etc*/

/*CHECKS IF THERE IS ANY USE OF A POST FUNCTION*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST' ) {
    header('location: index.php');
    exit;
}


/*ADD TEAM FUNCTION*/
if ($_POST['type'] === 'addteam'){
    $teamname = $_POST['teamname'];
    $teamleader = $_POST['teamleader'];
    $participants = $_POST['participants'];

    $sql = "INSERT INTO teams (teamname, teamleader, participants) VALUES (:teamname, :teamleader, :participants)";

    $prepare = $pdo->prepare($sql);
    $prepare->execute([
        ':teamname' => $teamname,
        ':teamleader' => $teamleader,
        ':participants' => $participants
    ]);

    $msg = "Team is succesvol toegevoegd!";

    header("location: dashboard.php?message=$msg");
    exit;
}

/*REGISTER FUNCTION*/
if ($_POST['type'] === 'register') {
    $username = trim($_POST['username']);
    $password1 = trim($_POST['password']);
    $password2 = trim($_POST['password_confirm']);

    $uppercase = PREG_MATCH('@[A-Z]@', $password1);
    $lowercase = PREG_MATCH('[@a-z]', $password1);
    $number = PREG_MATCH('[@0-9]', $password1);

    $user_check_query = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $user_check_query->execute([$username]);
    $account = $user_check_query->fetch();
    if ($account){
        ?>
        <script type="text/javascript">
            alert("this username is already in use");
            window.location.href = "register.php";
        </script>
        <?php
    }
    else{
        if($password1 === $password2)
        {

            if (!$uppercase || !$lowercase || !$number || !strlen($password1 < 7)){

            }
            $passwordHash = password_hash($password1, PASSWORD_DEFAULT);

            $sql = "INSERT INTO users (username, password)
                    VALUES (:username, :passwordHash)";
            $prepare = $pdo->prepare($sql);
            $prepare->execute([
                ':username' => $username,
                ':passwordHash' => $passwordHash
            ]);

            $msg = "gebruiker is succesvol toegevoegd!";

            header("location: login.php?message=$msg");
            exit;

        }
        else
        {
            ?>
            <script type="text/javascript">
                alert("The passwords do not match");
                window.location.href = "register.php";
            </script>
            <?php
        }
    }
}

/*LOGIN FUNCTION*/
if ( $_POST['type'] === 'login' ) {

    /*
     * Hier komen we als we de login form data versturen.
     * things to do:
     */


    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $user_login_username_check_query = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $user_login_username_check_query->execute([$username]);
    $account = $user_login_username_check_query->fetch();
    if ($account) {
        // username has been found

        $sql = "SELECT * FROM users WHERE username = :username";
        $prepare = $pdo->prepare($sql);
        $prepare->execute([
            ':username' => $username
        ]);
        $account = $prepare->fetch(PDO::FETCH_ASSOC);
        $inputPassword = trim($_POST['password']);

        if ($account) {
//            $isThePasswordCorrect = password_verify($hashedPassword, PASSWORD_DEFAULT);
            $validPassword = password_verify($inputPassword, $account['password']);
            if ($validPassword){
                // everything is oke
                echo "everything is oke";
                session_start();

                $_SESSION["loggedin"] = true;
                $_SESSION["id"] = $account["id"];
                header( "location: dashboard.php");
            }
            else {
                // wrong password try again.
                echo "wrong password try again.";
            }

        } else {
            // account not found redirect to register page.
            echo "password not found";
        }

    } else {
        // account not found redirect to register page.
        echo "username not found";
    }


    exit;
}


/*DELETE FUNCTION*/
if ( $_POST['type'] == 'delete'){
    $id = $_GET['id'];

    $sql = " DELETE from teams WHERE id = :id";
    $prepare =  $pdo->prepare($sql);
    $prepare->execute([
        ':id' => $id
    ]);


    $message = "Team is succesvol verwijderd";
    header("location: dashboard.php?message=$message");
}


/*UPDATE FUNCTION*/
if ( $_POST['type'] == 'edit'){

    $id = $_GET['id'];

    $teamname = $_POST['teamname'];
    $teamleader = $_POST['teamleader'];
    $participants = $_POST['participants'];

    $sql = "UPDATE teams SET teamname= :teamname,teamleader= :teamleader, participants= :participants WHERE id= :id";

    $prepare =  $pdo->prepare($sql);
    $prepare->execute([

        ':teamname' => $teamname,
        ':teamleader' => $teamleader,
        ':participants' => $participants,

        ':id' => $id

    ]);

    $message ="Team  is succesvol aangepast";
    header("location: dashboard.php");
    exit;

}