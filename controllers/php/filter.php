<?php
require '../../models/Model.php';

// Create an instance of the Model class
$model = new Model();

// Get the request body from the request
$jsonbody = file_get_contents('php://input');

// Parse the JSON string to a PHP array
$jsonbody = json_decode($jsonbody, true);

// Extract the aim_at and filterArray from the PHP array
$aim_at = $jsonbody['aim_at'];
$filterArray = $jsonbody['filterArray'];

// Get the media with the filter
$news = $model->getMediaWithFilter($aim_at, $filterArray);

// Encode the result as a JSON string
echo json_encode($news);
