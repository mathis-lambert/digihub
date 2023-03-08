<?php
require_once '../../models/Db.php';
// ##### NLP = Natural Language Processing #####

// Script to normalize the search query in order to 
// send the most optimized search query to search.php

// It is a NLP like script that will try to find the most relevant words
// in the search query and will return a URL 
// with types, genres, authors and keywords parameters

function spliSpacedWords($string)
{
    $string = preg_replace('/\s+/', ' ', $string);
    $string = trim($string);
    $string = explode(" ", $string);
    return $string;
}

// Get the search query
$words = $_GET['q'];
$wordsArray = explode(" ", $words);

// Get the media types
$mediaTypes = Db::quickFetchAll("types", "typeStatus", "available");
$mediaTypes = array_column($mediaTypes, 'typeName');
$mediaTypes = array_map('strtolower', $mediaTypes);
$type = array_intersect($wordsArray, $mediaTypes); // keep only the types that are in the search query

// Get the media genres
$mediaGenres = Db::quickFetchAll("genres", TRUE, TRUE);
$mediaGenres = array_column($mediaGenres, 'genreName');
$mediaGenres = array_map('strtolower', $mediaGenres);
$genre = array_intersect($wordsArray, $mediaGenres); // keep only the genres that are in the search query

// Get the media people
$mediaPeoplesDb = Db::quickFetchAll("peoples", TRUE, TRUE);
$mediaPeoples = array_column($mediaPeoplesDb, 'peopleFirstname');
$mediaPeoples = array_merge($mediaPeoples, array_column($mediaPeoplesDb, 'peopleLastname'));
$mediaPeoples = array_map('strtolower', $mediaPeoples);
$mediaPeoples = array_map('mb_convert_encoding', $mediaPeoples, array_fill(0, count($mediaPeoples), "UTF-8"), array_fill(0, count($mediaPeoples), "HTML-ENTITIES"));
$mediaPeoples = array_map('html_entity_decode', $mediaPeoples);
$mediaPeoples2 = array_map('spliSpacedWords', $mediaPeoples);
$mediaPeoples = array_merge(...$mediaPeoples2);
$mediaPeoples = array_unique($mediaPeoples);
$mediaPeoples = array_filter($mediaPeoples, function ($value) {
    return $value !== '';
});
$people = array_intersect($wordsArray, $mediaPeoples); // keep only the people that are in the search query

// Filter the words
$keywords = array_diff($wordsArray, $type, $genre, $people); // keep only the keywords that are in the search query

// Create the URL
$url = "search.php?method=searching&q=" . implode(" ", $keywords) . "&types=" . implode(" ", $type) . "&genres=" . implode(" ", $genre) . "&peoples=" . implode(" ", $people);

$json = json_encode([
    "url" => $url
]);

echo $json;
