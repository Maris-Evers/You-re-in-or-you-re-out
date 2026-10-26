<?php

session_start();

$host = '127.0.0.1';
$db = 'netland';
$user = 'bit_academy';
$pass = 'bit_academy';

if (!isset($_SESSION['loggedInUser']) || $_SESSION['loggedInUser'] == false) {
    header('Location: login.php');
    exit;
} else {
    if (!isset($_GET['id'])) {
        header('Location: index.php');
        exit;
    } else {
        $id = $_GET['id'];
    }
}


try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = 'SELECT * fROM media WHERE id = ' . $id;
    $media = $pdo->query($sql)->fetch();
    $stmt = $pdo->query('SELECT VERSION() AS version');
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Verbinding mislukt: " . $e->getMessage();
}

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

    .summary {
        border: 2px solid;
        border-color: yellow;
        border-radius: 5px;
        padding: 7px;
        margin-left: 15px;
        margin-right: 15px;
    }

    .btn {
        background-color: #39344d;
        text-decoration: none;
        color: white;
        padding: 3px 5px 3px 5px;
        margin-bottom: 5px;
    }
</style>

<body>
    <div class="container">
        <div>
            <h1><?= $media['title'] ?></h1>
            <a href="index.php" class="btn">«Terug</a>
            <table>
                <tr>
                    <th class="tablecell">Information</th>
                    <th class="tablecell">Information</th>
                </tr>
                <?php if ($media['rating'] != null) : ?>
                    <tr>
                        <td class="tablecell">Rating</td>
                        <td class="tablecell"><?= $media['rating'] ?></td>
                    </tr>
                <?php endif; ?>
                <?php if ($media['awards'] !== null) : ?>
                    <tr>
                        <td class="tablecell">Hoeveel awards</td>
                        <td class="tablecell"><?= $media['awards'] ?></td>
                    </tr>
                <?php endif; ?>
                <?php if ($media['length_in_minutes'] != null) : ?>
                    <tr>
                        <td class="tablecell">Duur</td>
                        <td class="tablecell"><?= $media['length_in_minutes'] ?></td>
                    </tr>
                <?php endif; ?>
                <?php if ($media['release_date'] != null) : ?>
                    <tr>
                        <td class="tablecell">Datum van uitkomst</td>
                        <td class="tablecell"><?= $media['release_date'] ?></td>
                    </tr>
                <?php endif; ?>
                <?php if ($media['seasons'] != null) : ?>
                    <tr>
                        <td class="tablecell">Seizoenen</td>
                        <td class="tablecell"><?= $media['seasons'] ?></td>
                    </tr>
                <?php endif; ?>
                <?php if ($media['origin'] != null) : ?>
                    <tr>
                        <td class="tablecell">Land van oorsprong</td>
                        <td class="tablecell"><?= $media['origin'] ?></td>
                    </tr>
                <?php endif; ?>
                <?php if ($media['youtube_trailer_id'] != null) : ?>
                    <tr>
                        <td class="tablecell">Youtube trailer</td>
                        <td class="tablecell"><?= $media['youtube_trailer_id'] ?></td>
                    </tr>
                <?php endif; ?>
            </table>
        </div>
        <div>
            <h2>Beschrijving</h2>
            <p class="summary"><?= $media['summary'] ?></p>
        </div>
        <a href="edit.php?id=<?= $id ?>">Edit information</a>
    </div>
</body>