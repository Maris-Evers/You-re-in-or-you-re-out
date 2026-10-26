<?php

session_start();

$host = '127.0.0.1';
$db = 'netland';
$user = 'bit_academy';
$pass = 'bit_academy';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->query('SELECT VERSION() AS version');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Verbinding mislukt: " . $e->getMessage();
}

if (isset($_POST['loginattempt'])) {
    if (empty($_POST['username']) || empty($_POST['passcode'])) {
        $errormessage = 'Je moet beide velden invullen';
    } else {
        $user = $_POST['username'];
        $pass = $_POST['passcode'];

        $sql = "SELECT * FROM `gebruikers` WHERE `username` = ? AND `wachtwoord` = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user, $pass]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row !== false) {
            $_SESSION['loggedInUser'] = $row['id'];
            header('Location: index.php');
        } else {
            $errormessage = 'Invalide gebruikersnaam/wachtwoord combinatie';
        }
    }
}
?>

<style>
    .container {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .errormessage {
        color: red;
    }
</style>

<html>

<body>
    <div class="container">
        <div>
            <h1>Netland Admin Panel</h1>
            <?php
            if (isset($errormessage)) : ?>
                <h3 class="errormessage"><?= $errormessage ?></h3>
            <?php endif; ?>
            <div>
                <form method="post">
                    <input name="username" id="username" type="text" placeholder="Username">
                    <input name="passcode" id="passcode" type="text" placeholder="Password">
                    <input name="loginattempt" type="submit" value="Login">
                </form>
            </div>
        </div>
    </div>


</body>

</html>