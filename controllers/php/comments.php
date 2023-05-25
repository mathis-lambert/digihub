<?php

include '../../models/Db.php';
include '../../models/Comments.php';

$body = file_get_contents("php://input");

$comment = json_decode($body);

$commentMediaId = $comment->commentMediaId;
$commentUserId = $comment->commentUserId;
$commentTitle = $comment->commentTitle;
$commentText = $comment->commentText;
$commentRating = $comment->commentRating;
$commentStatus = $comment->commentStatus;
$commentDate = $comment->commentDate;

if (!empty($commentMediaId) && !empty($commentUserId) && !empty($commentTitle) && !empty($commentText) && !empty($commentRating) && !empty($commentStatus) && !empty($commentDate)) {
    Comments::add($commentMediaId, $commentUserId, $commentTitle, $commentText, $commentRating, $commentStatus, $commentDate);
    $body = array(
        "success" => "Votre commentaire a bien été ajouté"
    );
} else {
    $body = array(
        "error" => "Veuillez remplir tous les champs"
    );
}