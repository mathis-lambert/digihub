<?php
require '../../config/config.php';

$search = strval($_GET['q']);
$method = strval($_GET['method']);

if ($method === "searching") {
    $filterSearchParam = explode(" ", $search);

    $criticalColumns = ['mediaName'];
    $importantColumns = ['mediaTags',  'authorLastname'];
    $minorColumns = ['mediaShortDesc', 'mediaLongDesc', 'typeName', 'mediaYear'];

    $mediasArr = [];

    foreach ($filterSearchParam as $word) {
        $word = strtolower($word);
        $medias = $conn->prepare("SELECT * FROM medias, types, authors WHERE medias.mediaTypeId = types.typeID AND medias.mediaAuthorId = authors.authorID AND concat_ws(' ', mediaName, mediaTags, mediaShortDesc, mediaLongDesc, typeName, authorLastname, authorFirstname, mediaYear) LIKE '%$word%' AND medias.mediaStatus = 'available'");
        $medias->execute();
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
        foreach ($filterSearchParam as $param) {
            $param = strtolower($param);

            $calculatedCoeff = 70;

            foreach ($criticalColumns as $column) {
                $i = count($criticalColumns);
                $multiplier = $calculatedCoeff > 70 ? $calculatedCoeff : 70;
                $coeff += round($multiplier / $i) / count($filterSearchParam);
                if (strpos(strtolower($media[$column]), $param . " ") !== false) {
                    $mediaPertinence += $multiplier / $i / count($filterSearchParam);
                }
            }
            foreach ($importantColumns as $column) {
                $i = count($importantColumns);
                $multiplier = $calculatedCoeff > 70 ? (100 - $calculatedCoeff) / 2 : 20;
                $coeff += round($multiplier / $i) / count($filterSearchParam);
                if (strpos(strtolower($media[$column]), $param) !== false) {
                    $mediaPertinence += $multiplier / $i / count($filterSearchParam);
                }
            }
            foreach ($minorColumns as $column) {
                $i = count($minorColumns);
                $multiplier = $calculatedCoeff > 70 ? (100 - $calculatedCoeff) / 2 : 10;
                $coeff += round($multiplier / $i) / count($filterSearchParam);
                if (strpos(strtolower($media[$column]), $param) !== false) {
                    $mediaPertinence += $multiplier / $i / count($filterSearchParam);
                }
            }
        }
        $mediaPertinence = round(($mediaPertinence / $coeff) * 1000) / 1000;
        //add pertinence to result array
        if ($mediaPertinence > 0) {
            $resultArray[] = ["media" => $media, "_pertinence" => $mediaPertinence, "_coeff" => $coeff, "_wordsTested" => count($filterSearchParam)];
        } else {
            unset($mediasArr[$key]);
        }
    }

    echo json_encode($resultArray);
}

if ($method === "result") {
}
