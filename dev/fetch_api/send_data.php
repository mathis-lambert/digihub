<?php
require '../../models/Db.php';
$conn = Db::getInstance();
//get json body
$json = file_get_contents('php://input');
//decode json
$json = json_decode($json, true);

function check_if_exists($table, $column, $id, $conn)
{
    $sql = "SELECT * FROM $table WHERE $column = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($result) {
        return true;
    } else {
        return false;
    }
}


if (isset($json['genres'])) {
    $genres = $json['genres'];
    for ($i = 0; $i < count($genres); $i++) {
        $genre = $genres[$i];
        $id = intval($genre['genreId']);
        $name = $genre['genreName'];

        try {
            $sql = "INSERT INTO genres (genreId, genreName) VALUES (:genreId, :genreName)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':genreId', $id);
            $stmt->bindParam(':genreName', $name);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    echo json_encode(array('status' => 'success -> Genre'));
}


if (isset($json['peoples'])) {
    $peoples = $json['peoples'];

    for ($i = 0; $i < count($peoples); $i++) {
        $people = $peoples[$i];
        $id = intval($people['peopleId']);
        $firstname = $people['peopleFirstname'];
        $lastname = $people['peopleLastname'];
        $fullname = $people['peopleFullname'];
        $birthdate = $people['peopleBirthday'];
        $deathdate = $people['peopleDeathday'];
        $birthplace = $people['peopleBirthplace'];
        $biography = $people['peopleBiography'];
        $picture = $people['peoplePicture'];
        $department = $people['peopleKnownForDepartment'];


        if (!check_if_exists('peoples', 'peopleId', $id, $conn)) {
            try {
                $sql = "INSERT INTO peoples (peopleId, peopleFirstname, peopleLastname, peopleFullname, peopleBirthday, peopleDeathday, peopleBirthplace, peopleBiography, peoplePicture, peopleKnownForDepartment) VALUES (:peopleId, :peopleFirstname, :peopleLastname, :peopleFullname, :peopleBirthday, :peopleDeathday, :peopleBirthplace, :peopleBiography, :peoplePicture, :peopleKnownForDepartment)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':peopleId', $id);
                $stmt->bindParam(':peopleFirstname', $firstname);
                $stmt->bindParam(':peopleLastname', $lastname);
                $stmt->bindParam(':peopleFullname', $fullname);
                $stmt->bindParam(':peopleBirthday', $birthdate);
                $stmt->bindParam(':peopleDeathday', $deathdate);
                $stmt->bindParam(':peopleBirthplace', $birthplace);
                $stmt->bindParam(':peopleBiography', $biography);
                $stmt->bindParam(':peoplePicture', $picture);
                $stmt->bindParam(':peopleKnownForDepartment', $department);
                $stmt->execute();
            } catch (PDOException $e) {
                echo json_encode(array('status' => $e->getMessage()));
            }
        } else {
            echo json_encode(array('status' => 'Actor already exists'));
        }
    }

    echo json_encode(array('status' => 'success -> People'));
}

if (isset($json['movies'])) {
    $movies = $json['movies'];
    for ($i = 0; $i < count($movies); $i++) {
        $movie = $movies[$i];

        $id = intval($movie['mediaId']);
        $title = $movie['mediaTitle'];
        $picture = $movie['mediaCoverImage'];
        $backdropPicture = $movie['mediaBackdropImage'];
        $video = $movie['mediaTrailer'];
        $description = $movie['mediaDescription'];
        $releaseDate = $movie['mediaPublishingDate'];
        $year = $movie['mediaYear'];
        $type = $movie['mediaTypeId'];


        $genreId = $movie['mediaGenres'];

        if (!check_if_exists('medias', 'mediaId', $id, $conn)) {
            try {
                $sql = "INSERT INTO medias (mediaId, mediaTypeId, mediaName, mediaDescription, mediaPublishingDate, mediaYear, mediaCoverImage, mediaBackgroundImage, mediaVideoLink) VALUES (:mediaId, :mediaTypeId, :mediaName, :mediaDescription, :mediaPublishingDate, :mediaYear, :mediaCoverImage, :mediaBackgroundImage , :mediaVideoLink)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':mediaId', $id);
                $stmt->bindParam(':mediaTypeId', $type);
                $stmt->bindParam(':mediaName', $title);
                $stmt->bindParam(':mediaDescription', $description);
                $stmt->bindParam(':mediaPublishingDate', $releaseDate);
                $stmt->bindParam(':mediaYear', $year);
                $stmt->bindParam(':mediaCoverImage', $picture);
                $stmt->bindParam(':mediaBackgroundImage', $backdropPicture);
                $stmt->bindParam(':mediaVideoLink', $video);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }


            echo json_encode(array('status' => 'success -> Movie'));
        } else {
            echo json_encode(array('status' => 'error -> Movie already exists, continue filling tables'));
        }

        for ($j = 0; $j < count($genreId); $j++) {
            $genre = $genreId[$j];
            try {
                $sql = "INSERT INTO appartient_genre (appartientGenreId, appartientMediaId) VALUES (:genreId, :mediaId)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':mediaId', $id);
                $stmt->bindParam(':genreId', $genre);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            echo json_encode(array('status' => 'success -> Genres related to movie'));
        }
    }
}

if (isset($json['appartient'])) {
    $appartients = $json['appartient'];
    for ($i = 0; $i < count($appartients); $i++) {
        $appartient = $appartients[$i];
        $mediaId = $appartient['mediaId'];
        $peopleId = $appartient['peopleId'];
        $departmentName = $appartient['departmentName'];
        $characterName = $appartient['characterName'];

        try {
            $sql = "INSERT INTO appartient_media (_mediaId, _peopleId, _departmentName, characterName) VALUES (:mediaId, :peopleId, :departmentName, :characterName)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':mediaId', $mediaId);
            $stmt->bindParam(':peopleId', $peopleId);
            $stmt->bindParam(':departmentName', $departmentName);
            $stmt->bindParam(':characterName', $characterName);
            $stmt->execute();
        } catch (PDOException $e) {
            echo json_encode(array('status' => $e->getMessage()));
        }
    }

    echo json_encode(array('status' => 'success -> Appartient'));
}
