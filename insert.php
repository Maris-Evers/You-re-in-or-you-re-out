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

if (isset($_POST["submit"])) {
    echo "media toegevoegd<br>";
    if (isset($_POST["title"])) {
        $title = $_POST["title"];
    }
    if (isset($_POST["rating"])) {
        $rating = $_POST["rating"];
        echo $rating . '<br>';
    }
    if (isset($_POST["summary"])) {
        $summary = $_POST["summary"];
    }
    if (isset($_POST["awards"])) {
        $awards = $_POST["awards"];
        echo $awards . '<br>';
    }
    if (isset($_POST["length_in_minutes"])) {
        $length_in_minutes = $_POST["length_in_minutes"];
    }
    if (isset($_POST["release_date"])) {
        $release_date = $_POST["release_date"];
        echo $release_date . '<br>';
    }
    if (isset($_POST["seasons"])) {
        $seasons = $_POST["seasons"];
    }
    if (isset($_POST["origin"])) {
        $origin = $_POST["origin"];
    }
    if (isset($_POST["youtube_trailer_id"])) {
        $youtube_trailer_id = $_POST["youtube_trailer_id"];
    }
    if (isset($_POST["type_media"])) {
        $type_media = $_POST["type_media"];
    }

    $sql = "INSERT INTO media (`title`, `rating`, `summary`, `awards`, `length_in_minutes`, `release_date`, `seasons`, `origin`, `youtube_trailer_id`, `type_media`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);
    ";
    $stmt = $pdo->prepare($sql);

    $stmt->execute([$title, $rating, $summary, $awards, $length_in_minutes, $release_date, $seasons, $origin, $youtube_trailer_id, $type_media]);
}

$media = ['title' => '', 'rating' => '', 'summary' => '', 'awards' => '', 'length_in_minutes' => '',
'release_date' => '', 'seasons' => '', 'origin' => '', 'youtube_trailer_id' => '', 'type_media' => ''];
       
?>

<style>
    body {
        background-color: #060026;
        color: white;
    }

    input,
    textarea,
    button,
    select {
        background-color: #39344d;
        border: none;
        color: white;
    }

    textarea {
        width: 100%;
        height: 75px;
    }

    .submitbutton {
        color: white;
        padding: 5px;
    }

    tr {
        text-align: left;
    }

    th,
    td {
        padding-top: 5px;
        padding-bottom: 5px;
    }

    label {
        padding: 10px;
    }

    .container {
        display: flex;
        justify-content: center;
    }

    .btn {
        background-color: #39344d;
        text-decoration: none;
        color: white;
        padding: 3px 5px 3px 5px;
    }

    h1 {
        text-align: center;
    }
</style>

<body>
    <div class="container">
        <div>
            <h1>Media Toevoegen</h1>
            <a href="index.php" class="btn">«Terug</a>
            <form method="post">
                <table>
                    <tr>
                        <th>
                            <label for="title">*Titel:</label>
                        </th>
                        <td>
                            <input name="title" id="title" type="text" value="<?= $media['title'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="rating">Rating:</label>
                        </th>
                        <td>
                            <input name="rating" id="rating" type="text" value="<?= $media['rating'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="summary">*Omschrijving:</label>
                        </th>
                        <td>
                            <textarea name="summary" id="summary"><?= $media['summary'] ?></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="awards">Aantal awards:</label>
                        </th>
                        <td>
                            <input name="awards" id="awards" type="text" value="<?= $media['awards'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="length_in_minutes">Lengte in minuten:</label>
                        </th>
                        <td>
                            <input name="length_in_minutes" id="length_in_minutes" type="text" value="<?= $media['length_in_minutes'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="release_date">Releasedatum:</label>
                        </th>
                        <td>
                            <input name="release_date" id="release_date" type="date" value="<?= $media['release_date'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="seasons">Seizoenen:</label>
                        </th>
                        <td>
                            <input name="seasons" id="seasons" type="text" value="<?= $media['seasons'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="origin">Land:</label>
                        </th>
                        <td>
                            <input name="origin" id="origin" type="text" value="<?= $media['origin'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="youtube_trailer_id">YouTube trailer ID:</label>
                        </th>
                        <td>
                            <input name="youtube_trailer_id" id="youtube_trailer_id" type="text" value="<?= $media['youtube_trailer_id'] ?>">
                        </td>
                    </tr>
                    <tr>
                        <th>
                            <label for="type_media">Type media:</label>
                        </th>
                        <td>
                            <select name="type_media" id="type_media">
                                <option value="1">Film</option>
                                <option value="2">Serie</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input name="submit" type="submit" class="submitbutton" value="Opslaan">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</body>
