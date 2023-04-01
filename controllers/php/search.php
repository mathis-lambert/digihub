<?php
require_once '../../models/Db.php';

function getScore($scoreName, $keywords, $arrToGetScore, $criticalColumn = [], ?array $majorColumn = [], ?array $minorColumn = [], ?int $maxResult = 50)
{
    /* Pour chaque mots, je veux chercher une occurence dans une des colonnes $importantColumns & $minorColumns
* un taux de pertinence sera calculé en fonction du nombre de mots trouvés dans la colonne
* et du nombre de mots recherchés
* le taux de pertinence sera stocké dans un tableau associé à l'ID du média
* le tableau sera trié par ordre décroissant de pertinence
*/
    $score = 0;
    $result = [];
    $result[$scoreName . "s"] = [];
    foreach ($arrToGetScore as $key => $value) {
        $score = 0;
        $coeff = 0;
        foreach ($keywords as $keyword) {
            $keyword = strtolower($keyword);
            $calculatedCoeff = 70;
            for ($i = 0; $i < count($criticalColumn); $i++) {
                $multiplier = $calculatedCoeff > 70 ? (100 - $calculatedCoeff) / 2 : 70;
                $coeff += round($multiplier / count($criticalColumn)) / count($keywords);
                if (is_null($value[$criticalColumn[$i]])) {
                    $value[$criticalColumn[$i]] = "";
                }
                if (stripos($value[$criticalColumn[$i]], $keyword, 0) !== false) {
                    $score += round($multiplier / count($criticalColumn)) / count($keywords);
                }
            }
            for ($i = 0; $i < count($majorColumn); $i++) {
                $multiplier = $calculatedCoeff > 70 ? (100 - $calculatedCoeff) / 2 : 20;
                $coeff += round($multiplier / count($majorColumn)) / count($keywords);
                if (is_null($value[$majorColumn[$i]])) {
                    $value[$majorColumn[$i]] = "";
                }
                if (stripos($value[$majorColumn[$i]], $keyword, 0) !== false) {
                    $score += round($multiplier / count($majorColumn)) / count($keywords);
                }
            }
            for ($i = 0; $i < count($minorColumn); $i++) {
                $multiplier = $calculatedCoeff > 70 ? (100 - $calculatedCoeff) / 2 : 10;
                $coeff += round($multiplier / count($minorColumn)) / count($keywords);
                if (is_null($value[$minorColumn[$i]])) {
                    $value[$minorColumn[$i]] = "";
                }
                if (stripos($value[$minorColumn[$i]], $keyword, 0) !== false) {
                    $score += round($multiplier / count($minorColumn)) / count($keywords);
                }
            }

            $score = round(($score / $coeff) * 1000) / 1000;
        }
        //add pertinence to result array
        if ($score > 0) {
            $result[$scoreName . "s"][] = ["_score" => $score, "_coeff" => $coeff, "_wordsTested" => $keywords, $scoreName => $arrToGetScore[$key]];
        } else {
            unset($result[$scoreName . "s"][$key]); //remove useless data
        }
    }
    if (count($result[$scoreName . "s"]) > $maxResult) {
        $result[$scoreName . "s"] = array_slice($result[$scoreName . "s"], 0, $maxResult);
    }
    usort($result[$scoreName . "s"], function ($a, $b) {
        return $b['_score'] <=> $a['_score'];
    });
    return $result;
}

$method = strval($_GET['method']) ?? "searching";
$keywords = strval($_GET['q']) ?? "";
$types = strval($_GET['types']) ?? "";
$genres = strval($_GET['genres']) ?? "";
$peoples = strval($_GET['peoples']) ?? "";


if ($method === "searching") {
    //create array from keywords, types and genres
    $keywords = explode(" ", $keywords);
    $types = explode(" ", $types);
    $genres = explode(" ", $genres);
    $peoples = explode(" ", $peoples);

    // all first letters to uppercase
    $genres = array_map('ucfirst', $genres);
    $types = array_map('ucfirst', $types);
    $peoples = array_map('ucfirst', $peoples);
    $peoples[] = implode(" ", $peoples);

    // Split authors into firstname and lastname
    $peoplesFirstname = [];
    $peoplesLastname = [];

    // reconvert mb strings to normal strings
    $keywords = array_map('strval', $keywords);
    $genres = array_map('strval', $genres);
    $types = array_map('strval', $types);
    $peoples = array_map('strval', $peoples);

    /*     print_r($peoples);
    print_r($genres);
    print_r($types);
    print_r($keywords); */


    $peoplesDatabase = Db::getInstance()->prepare("SELECT peopleFirstname, peopleLastname, peopleFullname FROM peoples");
    $peoplesDatabase->execute();
    $peoplesDatabase = $peoplesDatabase->fetchAll(PDO::FETCH_ASSOC);
    foreach ($peoples as $people) {
        foreach ($peoplesDatabase as $peopleDatabase) {
            if ($people === $peopleDatabase['peopleFullname']) {
                $peoplesLastname[] = $peopleDatabase['peopleLastname'];
                $peoplesFirstname[] = $peopleDatabase['peopleFirstname'];
                break;
            }

            if ($people === $peopleDatabase['peopleLastname']) {
                $peoplesLastname[] = $peopleDatabase['peopleLastname'];
            }

            if ($people === $peopleDatabase['peopleFirstname']) {
                $peoplesFirstname[] = $peopleDatabase['peopleFirstname'];
            }
        }
    }

    // if people's arrays are empty, we add a random string to avoid errors
    empty($peoplesLastname) ? $peoplesLastname[] = "" : $peoplesLastname;
    empty($peoplesFirstname) ? $peoplesFirstname[] = "" : $peoplesFirstname;

    // remove duplicates
    $peoplesLastname = array_unique($peoplesLastname);
    $peoplesFirstname = array_unique($peoplesFirstname);

    // bools to check if the user has entered a type or a genre
    $queryBool = $keywords[0] === "";
    $typesBool = $types[0] === "";
    $genresBool = $genres[0] === "";
    $peoplesFirstnameBool = $peoplesFirstname[0] === "";
    $peoplesLastnameBool = $peoplesLastname[0] === "";

    // columns to search in and their importance
    $criticalColumns = ['mediaName'];
    $importantColumns = ['genreName', 'mediaTags', '_departmentName', 'characterName'];
    $minorColumns = ['mediaDescription', 'typeName', 'mediaYear', 'peopleFirstname', 'peopleLastname', 'peopleFullname'];

    // init array to store medias
    $mediasArr = [];

    // init sql queries for types and genres
    $querySql = "AND concat_ws(' ', medias.mediaName, medias.mediaTags, medias.mediaDescription, types.typeName, medias.mediaYear, genres.genreName, peoples.peopleFirstname, peoples.peopleLastname, appartient_media._departmentName, appartient_media.characterName) LIKE ? ";
    $sqlTypes = " AND types.typeName IN ('" . implode("', '", $types) . "')";
    $sqlGenres = " AND genres.genreName IN ('" . implode("', '", $genres) . "')";
    $sqlPeopleLastname = " AND peoples.peopleLastname IN ('" . implode("', '", $peoplesLastname) . "')";
    $sqlPeopleFirstname = " AND peoples.peopleFirstname IN ('" . implode("', '", $peoplesFirstname) . "')";

    foreach ($keywords as $word) {
        $word = strtolower($word);
        $sql = "SELECT * FROM medias, genres, types, peoples, appartient_genre, appartient_media WHERE medias.mediaTypeId = types.typeID AND medias.mediaId = appartient_media._mediaId  AND appartient_media._peopleId = peoples.peopleId AND medias.mediaId = appartient_genre.appartientMediaId AND genres.genreId = appartient_genre.appartientGenreId AND medias.mediaStatus = 'available'" . ($typesBool ? "" : $sqlTypes) . ($genresBool ? "" : $sqlGenres) . ($queryBool ? "" : $querySql) . ($peoplesLastnameBool ? "" : $sqlPeopleLastname) . ($peoplesFirstnameBool ? "" : $sqlPeopleFirstname) . ' GROUP BY medias.mediaId';
        $medias = Db::getInstance()->prepare($sql);
        if (!$queryBool) {
            $medias->execute([sprintf('%%%s%%', $word)]);
        } else {
            $medias->execute();
        }
        $medias = $medias->fetchAll(PDO::FETCH_ASSOC);
        if ($medias) {
            foreach ($medias as $media) {
                if (!in_array($media, $mediasArr)) {
                    $mediasArr[] = $media;
                }
            }
        }
    }
    $resultMedia = getScore("media", $keywords, $mediasArr, $criticalColumns, $importantColumns, $minorColumns);
    $criticalColumns = ['peopleFirstname'];
    $importantColumns = ['peopleLastname', "peopleFullname"];
    $minorColumns = ['peoplePicture', 'peopleBiography'];
    $resultPeople = ["peoples" => []];
    if (!$peoplesFirstnameBool || !$peoplesLastnameBool) {
        $peoplesArray = [];
        foreach ($peoples as $people) {
            $sql = "SELECT * FROM peoples WHERE concat_ws(' ', peoples.peopleFullname) LIKE ? GROUP BY peoples.peopleId LIMIT 5";
            $peopleDb = Db::getInstance()->prepare($sql);
            $peopleDb->execute([sprintf('%%%s%%', $people)]);
            $peopleDb = $peopleDb->fetchAll(PDO::FETCH_ASSOC);
            if ($peopleDb) {
                foreach ($peopleDb as $people) {
                    if (!in_array($people, $peoplesArray)) {
                        $peoplesArray[] = $people;
                    }
                }
            }
        }
        $resultPeople = getScore("people", $peoples, $peoplesArray, $criticalColumns, $importantColumns, $minorColumns);
    } else {
        $resultPeople = ["peoples" => []];
    }
    $result = array_merge($resultMedia, $resultPeople);
    echo json_encode($result);






    //order result array by pertinence
    /*     usort($resultArray, function ($a, $b) {
        return $b['_pertinence'] <=> $a['_pertinence'];
    });

    $resultArray = array_slice($resultArray, 0, $MAX_RESULTS); */

    //echo json_encode($resultArray);
}




if ($method === "result") {
}
