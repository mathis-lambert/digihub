<?php
require '../../config/config.php';

$search = strval($_GET['q']);
$filterSearchValue = explode(" ", $search);
$searchParams = "";
foreach ($filterSearchValue as $value) {
    $searchParams .= "concat_ws(' ', mediaName, mediaShortDesc, mediaLongDesc, mediaAddedDate, mediaPublishingDate, mediaStatus, mediaAuthorId, mediaTags) LIKE '%$value%' AND ";
}

$searchParams = substr($searchParams, 0, -4);

$media = $conn->prepare("SELECT * FROM medias WHERE $searchParams");
$media->execute();
$media = $media->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($media);
