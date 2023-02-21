<?php
require '../../config/config.php';

// ##### NLP = Natural Language Processing #####

// Script to normalize the search query in order to 
// send the most optimized search query to search.php

// It is a NLP like script that will try to find the most relevant words
// in the search query and will return a URL 
// with types, genres and keywords parameters


// Get the search query
$words = $_GET['q'];
$wordsArray = explode(" ", $words);

// Get the media types
$mediaTypes = quickFetchAll($conn, "types", "typeStatus", "available");
$mediaTypes = array_column($mediaTypes, 'typeName');
$mediaTypes = array_map('strtolower', $mediaTypes);
$type = array_intersect($wordsArray, $mediaTypes); // keep only the types that are in the search query

// Get the media genres
$mediaGenres = quickFetchAll($conn, "genres", TRUE, TRUE);
$mediaGenres = array_column($mediaGenres, 'genreName');
$mediaGenres = array_map('strtolower', $mediaGenres);
$genre = array_intersect($wordsArray, $mediaGenres); // keep only the genres that are in the search query

// Filter the words
$keywords = array_diff($wordsArray, $mediaTypes, $mediaGenres); // keep only the keywords that are not included in the types and genres

// Create the URL
$url = "search.php?method=searching&q=" . implode(" ", $keywords) . "&types=" . implode(" ", $type) . "&genres=" . implode(" ", $genre);

$json = json_encode([
    "url" => $url
]);

echo $json;
