<?php
$mediaId = $_GET[1];
$userId = $_SESSION['user']->id;
$favorite = Favorites::find($userId, $mediaId);
if (is_null($favorite)) {
    $favorite = new Favorites(null, $mediaId, $userId);
    $favorite->add($mediaId, $userId);
}
header('Location: ./?view&id=' . $mediaId);
