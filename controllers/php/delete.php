<?php
$id = $_GET['id'];

if (!empty($_SESSION) && isset($_SESSION['userId'])) {
    if ($_SESSION['userRole'] == 2) {
        $pdo = new Db();
        $sql = "UPDATE medias SET mediaStatus = 'disabled' WHERE mediaId = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        header('Location: ./');
    } else {
        header('<meta http-equiv="refresh" content="0;URL=./?404">');
    }
}
