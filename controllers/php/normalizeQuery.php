<?php
try {
    // Database credentials
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'digihub');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');

    // Create connection
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec('SET NAMES "utf8"');

    require '../../config/config.php';
    // ##### NLP = Natural Language Processing #####

    // Script to normalize the search query in order to 
    // send the most optimized search query to search.php

    // It is a NLP like script that will try to find the most relevant words
    // in the search query and will return a URL 
    // with types, genres, authors and keywords parameters


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

    // Get the media authors
    $mediaAuthorsDb = quickFetchAll($conn, "authors", TRUE, TRUE);
    $mediaAuthors = array_column($mediaAuthorsDb, 'authorFirstname');
    $mediaAuthors = array_merge($mediaAuthors, array_column($mediaAuthorsDb, 'authorLastname'));
    $mediaAuthors = array_map('strtolower', $mediaAuthors);
    $author = array_intersect($wordsArray, $mediaAuthors); // keep only the authors that are in the search query

    // Filter the words
    $keywords = array_diff($wordsArray, $mediaTypes, $mediaGenres, $mediaAuthors); // keep only the keywords that are not included in the types and genres

    // Create the URL
    $url = "search.php?method=searching&q=" . implode(" ", $keywords) . "&types=" . implode(" ", $type) . "&genres=" . implode(" ", $genre) . "&authors=" . implode(" ", $author);

    $json = json_encode([
        "url" => $url
    ]);

    echo $json;
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
