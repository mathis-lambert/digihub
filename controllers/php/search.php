<?php
require '../../config/config.php';

$method = strval($_GET['method']) ?? "searching";
$keywords = strval($_GET['q']) ?? "";
$types = strval($_GET['types']) ?? "";
$genres = strval($_GET['genres']) ?? "";
$authors = strval($_GET['authors']) ?? "";


if ($method === "searching") {
    //create array from keywords, types and genres
    $keywords = explode(" ", $keywords);
    $types = explode(" ", $types);
    $genres = explode(" ", $genres);
    $authors = explode(" ", $authors);

    // all first letters to uppercase
    $genres = array_map('ucfirst', $genres);
    $types = array_map('ucfirst', $types);
    $authors = array_map('ucfirst', $authors);

    // Split authors into firstname and lastname
    $authorsLastname = [];
    $authorsFirstname = [];

    $authorsDatabase = quickFetchAll($conn, "authors", TRUE, TRUE);
    foreach ($authors as $author) {
        foreach ($authorsDatabase as $authorDatabase) {
            if ($author === $authorDatabase['authorLastname']) {
                $authorsLastname[] = $authorDatabase['authorLastname'];
            }

            if ($author === $authorDatabase['authorFirstname']) {
                $authorsFirstname[] = $authorDatabase['authorFirstname'];
            }
        }
    }

    // if author's arrays are empty, we add a random string to avoid errors
    empty($authorsLastname) ? $authorsLastname[] = "" : $authorsLastname;
    empty($authorsFirstname) ? $authorsFirstname[] = "" : $authorsFirstname;

    // bools to check if the user has entered a type or a genre
    $typesBool = $types[0] === "";
    $genresBool = $genres[0] === "";
    $authorsFirstnameBool = $authorsFirstname[0] === "";
    $authorsLastnameBool = $authorsLastname[0] === "";

    // columns to search in and their importance
    $criticalColumns = ['mediaName'];
    $importantColumns = ['authorLastname', 'genreName', 'authorFirstname', 'authorLastname', 'mediaTags'];
    $minorColumns = ['mediaDescription', 'typeName', 'mediaYear'];

    // init array to store medias
    $mediasArr = [];

    // init sql queries for types and genres
    $sqlTypes = " AND types.typeName IN ('" . implode("', '", $types) . "')";
    $sqlGenres = " AND genres.genreName IN ('" . implode("', '", $genres) . "')";
    $sqlAuthorsLastname = " AND authors.authorLastname IN ('" . implode("', '", $authorsLastname) . "')"; // lastname
    $sqlAuthorsFirstname = " AND authors.authorFirstname IN ('" . implode("', '", $authorsFirstname) . "')"; // firstname

    foreach ($keywords as $word) {
        $word = strtolower($word);
        $sql = "SELECT * FROM medias, authors, genres, types, appartient_genre, appartient_author WHERE medias.mediaTypeId = types.typeID AND medias.mediaId = appartient_author.appartientMediaId  AND appartient_author.appartientAuthorId = authors.authorId AND medias.mediaId = appartient_genre.appartientMediaId AND genres.genreId = appartient_genre.appartientGenreId AND concat_ws(' ', medias.mediaName, medias.mediaTags, medias.mediaDescription, types.typeName, authors.authorLastname, authors.authorFirstname, medias.mediaYear, genres.genreName) LIKE ? AND medias.mediaStatus = 'available'" . ($typesBool ? "" : $sqlTypes) . ($genresBool ? "" : $sqlGenres) . ($authorsLastnameBool ? "" : $sqlAuthorsLastname) . ($authorsFirstnameBool ? "" : $sqlAuthorsFirstname) . " GROUP BY medias.mediaId";
        $medias = $conn->prepare($sql);
        $medias->execute([sprintf('%%%s%%', $word)]);
        $medias = $medias->fetchAll(PDO::FETCH_ASSOC);
        if ($medias) {
            foreach ($medias as $media) {
                if (!in_array($media, $mediasArr)) {
                    $mediasArr[] = $media;
                }
            }
        }
    }


    /* Pour chaque mots, je veux chercher une occurence dans une des colonnes $importantColumns & $minorColumns
* un taux de pertinence sera calculé en fonction du nombre de mots trouvés dans la colonne
* et du nombre de mots recherchés
* le taux de pertinence sera stocké dans un tableau associé à l'ID du média
* le tableau sera trié par ordre décroissant de pertinence
*/

    $resultArray = [];

    foreach ($mediasArr as $key => $media) {
        $mediaPertinence = 0;
        $coeff = 0;

        foreach ($keywords as $keyword) {
            $keyword = strtolower($keyword);


            $calculatedCoeff = 70;

            for (
                $i = 0;
                $i < count($criticalColumns);
                $i++
            ) {
                $multiplier = $calculatedCoeff > 70 ? (100 - $calculatedCoeff) / 2 : 70;
                $coeff += round($multiplier / count($criticalColumns)) / count($keywords);
                if (stripos($media[$criticalColumns[$i]], $keyword) !== false) {
                    $mediaPertinence += round($multiplier / count($criticalColumns)) / count($keywords);
                }
            }

            for (
                $i = 0;
                $i < count($importantColumns);
                $i++
            ) {
                $multiplier = $calculatedCoeff > 70 ? (100 - $calculatedCoeff) / 2 : 20;
                $coeff += round($multiplier / count($importantColumns)) / count($keywords);
                if (stripos($media[$importantColumns[$i]], $keyword) !== false) {
                    $mediaPertinence += round($multiplier / count($importantColumns)) / count($keywords);
                }
            }

            for ($i = 0; $i < count($minorColumns); $i++) {
                $multiplier = $calculatedCoeff > 70 ? (100 - $calculatedCoeff) / 2 : 10;
                $coeff += round($multiplier / count($minorColumns)) / count($keywords);
                if (stripos($media[$minorColumns[$i]], $keyword) !== false) {
                    $mediaPertinence += round($multiplier / count($minorColumns)) / count($keywords);
                }
            }
        }
        $mediaPertinence = round(($mediaPertinence / $coeff) * 1000) / 1000;
        //add pertinence to result array
        if ($mediaPertinence > 0) {
            $resultArray[] = ["media" => $media, "_pertinence" => $mediaPertinence, "_coeff" => $coeff, "_wordsTested" => count($keywords)];
        } else {
            //unset($mediasArr[$key]);
        }
    }

    $MAX_RESULTS = 50;

    //order result array by pertinence
    usort($resultArray, function ($a, $b) {
        return $b['_pertinence'] <=> $a['_pertinence'];
    });

    $resultArray = array_slice($resultArray, 0, $MAX_RESULTS);

    echo json_encode($resultArray);
}




if ($method === "result") {
}
