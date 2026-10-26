<?php

session_start();

if (!isset($_SESSION['loggedInUser']) || $_SESSION['loggedInUser'] == false) {
    header('Location: login.php');
    exit;
}

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




$sortRating = '';
$sortDuration = '';

if (isset($_GET['sSort'])) {
    $sortRating = ' ORDER BY rating ' . $_GET['sSort'];
}

if (isset($_GET['mSort'])) {
    $sortDuration = ' ORDER BY length_in_minutes ' . $_GET['mSort'];
}

$sdata = $pdo->query('SELECT id, title, rating FROM media WHERE type_media = 2' . $sortRating)->fetchAll(PDO::FETCH_ASSOC);
$mdata = $pdo->query('SELECT id, title, length_in_minutes FROM media WHERE type_media = 1' . $sortDuration)->fetchAll(PDO::FETCH_ASSOC);

$sortState = $_SERVER['QUERY_STRING'];


?>

<style>
    body {
        background-color: #060026;
        color: white;
    }


    .container {
        text-align: center;
        display: flex;
        align-items: center;
        flex-direction: column;
    }

    .tablecell {
        background-color: #433e54;
        padding-top: 5px;
        padding-bottom: 5px;
        padding-left: 15px;
        padding-right: 15px;
        color: #a5a1b5;
    }

    .logout {
        position: absolute;
        top: 5%;
        right: 5%;
    }

    .logout input {
        padding: 7px;
        font-size: 17px;
    }
</style>

<body>
    <div class="logout">
        <form action="logout.php" method="POST">
            <input type="submit" value="Log out" />
        </form>
    </div>
    <div class="container">
        <h1>Welkom op het netland beheerders paneel</h1>
        <div>
            <h2>Series</h2>
            <table>
                <tr>
                    <th class="tablecell">Title</th>
                    <th class="tablecell">
                        <a style="color: #a5a1b5;" href="./sort.php?type=s&<?= $sortState ?>">
                            Rating
                        </a>
                    </th>
                    <th class="tablecell">Details</th>
                </tr>
                <?php

                foreach ($sdata as $serie) {
                    ?>
                    <tr>
                        <td class="tablecell"><?= $serie['title'] ?></td>
                        <td class="tablecell"><?= $serie['rating'] ?></td>
                        <td class="tablecell">
                            <a style="text-decoration: none; color: #a5a1b5;" href="detail.php?id=<?= $serie['id'] ?>">Bekijk details</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>

        <div>
            <h2>Films</h2>
            <table>
                <tr>
                    <th class="tablecell">Title</th>
                    <th class="tablecell">
                        <a style="color: #a5a1b5;" href="./sort.php?type=m&<?= $sortState ?>">Duur</a>
                    </th>
                    <th class="tablecell">Details</th>
                </tr>
                <?php

                foreach ($mdata as $film) {
                    ?>
                    <tr>
                        <td class="tablecell"><?= $film['title'] ?></td>
                        <td class="tablecell"><?= $film['length_in_minutes'] ?></td>
                        <td class="tablecell">
                            <a style="text-decoration: none; color: #a5a1b5;" href="detail.php?id=<?= $film['id'] ?>">Bekijk details</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <br>
        <a href="insert.php">Voeg media toe</a>

    </div>
</body>