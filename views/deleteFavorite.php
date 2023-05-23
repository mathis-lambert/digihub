<?php
$mediaId = $_GET['id'];
$userId = $_SESSION['user']->id;
$favorite = Favorites::find($userId, $mediaId);
if (!is_null($favorite)) {
    $favorite->delete($mediaId, $userId);
}
header('Location: ./?view&id=' . $mediaId);
