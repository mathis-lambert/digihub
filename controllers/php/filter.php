<?php
require '../../models/Model.php';

$model = new Model();

$jsonbody = file_get_contents('php://input');
$jsonbody = json_decode($jsonbody, true);
$aim_at = $jsonbody['aim_at'];
$filterArray = $jsonbody['filterArray'];

$news = $model->getMediaWithFilter($aim_at, $filterArray);
echo json_encode($news);
