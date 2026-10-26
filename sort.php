<?php

if (!isset($_GET['type'])) {
    header('Location: index.php');
    exit;
}

var_dump($_GET);

$newState = '';



if ($_GET['type'] == 's') {
    if ($_GET['sSort'] == 'DESC') {
        $newState = "sSort=ASC";
    } else {
        $newState = "sSort=DESC";
    }

    if (isset($_GET['mSort'])) {
        $newState .= '&mSort=' . $_GET['mSort'];
    }
}


if ($_GET['type'] == 'm') {
    if ($_GET['mSort'] == 'DESC') {
        $newState = "mSort=ASC";
    } else {
        $newState = "mSort=DESC";
    }

    if (isset($_GET['sSort'])) {
        $newState = 'sSort=' . $_GET['sSort'] . '&' . $newState;
    }
}

header('Location: index.php?' . $newState);
exit;

?>
