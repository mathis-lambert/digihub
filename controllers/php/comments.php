<?php

include '../../models/Db.php';
include '../../models/Comments.php';
include '../../models/User.php';

$body = file_get_contents("php://input");

$comment = json_decode($body);

$commentMediaId = $comment->commentMediaId;
$commentUserId = $comment->commentUserId;
$commentText = $comment->commentText;
$commentRating = $comment->commentRating;
$commentStatus = $comment->commentStatus;
$commentDate = $comment->commentDate;

if (!empty($commentMediaId) && !empty($commentUserId) && !empty($commentText) && !empty($commentRating) && !empty($commentStatus) && !empty($commentDate)) {
    try {
        Comments::add($commentMediaId, $commentUserId, $commentText, $commentRating, $commentStatus, $commentDate);
        $body = array(
            "success" => "Votre commentaire a bien été ajouté",
            "user" => User::find($commentUserId)->userFirstname
        );
    } catch (Exception $e) {
        $body = array(
            "error" => "Une erreur inconnue est survenue"
        );
    }
} else {
    $body = array(
        "error" => "Veuillez remplir tous les champs"
    );
}

$json = json_encode($body);
echo $json;
