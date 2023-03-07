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

if (isset($json['authors'])) {
    $authors = $json['authors'];
    for ($i = 0; $i < count($authors); $i++) {
        $author = $authors[$i];
        $id = intval($author['directorId']);
        $firstname = $author['directorFirstname'];
        $lastname = $author['directorLastname'];
        $birthdate = $author['directorBirthDate'];
        $biography = $author['directorBiography'];
        $picture = $author['directorProfileImage'];
        $department = $author['directorDepartment'];
        $birthplace = $author['directorBirthPlace'];

        if (!check_if_exists('authors', 'authorId', $id, $conn)) {
            try {
                $sql = "INSERT INTO authors (authorId, authorFirstname, authorLastname, authorBirthdate, authorBiography, authorPicture, authorDepartment, authorBirthplace) VALUES (:authorId, :authorFirstname, :authorLastname, :authorBirthdate, :authorBiography, :authorPicture, :authorDepartment, :authorBirthplace)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':authorId', $id);
                $stmt->bindParam(':authorFirstname', $firstname);
                $stmt->bindParam(':authorLastname', $lastname);
                $stmt->bindParam(':authorBirthdate', $birthdate);
                $stmt->bindParam(':authorBiography', $biography);
                $stmt->bindParam(':authorPicture', $picture);
                $stmt->bindParam(':authorDepartment', $department);
                $stmt->bindParam(':authorBirthplace', $birthplace);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    echo json_encode(array('status' => 'success -> Author'));
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

if (isset($json['actors'])) {
    $actors = $json['actors'];

    for ($i = 0; $i < count($actors); $i++) {
        $actor = $actors[$i];
        $id = intval($actor['actorId']);
        $fullName = $actor['actorFullname'];
        $birthdate = $actor['actorBirthDate'];
        $deathdate = $actor['actorDeathDate'];
        $biography = $actor['actorBiography'];
        $picture = $actor['actorProfileImage'];
        $department = $actor['actorDepartment'];
        if (!check_if_exists('actors', 'actorId', $id, $conn)) {
            try {
                $sql = "INSERT INTO actors (actorId, actorFullname, actorBirthday, actorDeathday, actorBiography, actorCoverImage, actorMainDepartment) VALUES (:actorId, :actorFullname, :actorBirthdate, :actorDeathdate, :actorBiography, :actorPicture, :actorDepartment)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':actorId', $id);
                $stmt->bindParam(':actorFullname', $fullName);
                $stmt->bindParam(':actorBirthdate', $birthdate);
                $stmt->bindParam(':actorDeathdate', $deathdate);
                $stmt->bindParam(':actorBiography', $biography);
                $stmt->bindParam(':actorPicture', $picture);
                $stmt->bindParam(':actorDepartment', $department);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }
        }
    }

    echo json_encode(array('status' => 'success -> Actor'));
}

if (isset($json['movies'])) {
    $movies = $json['movies'];
    for ($i = 0; $i < count($movies); $i++) {
        $movie = $movies[$i];

        $id = intval($movie['mediaId']);
        $title = $movie['mediaTitle'];
        $picture = $movie['mediaCoverImage'];
        $backdropPicture = $movie['mediaBackdropImage'];
        $description = $movie['mediaDescription'];
        $releaseDate = $movie['mediaPublishingDate'];
        $year = $movie['mediaYear'];
        $type = $movie['mediaTypeId'];


        $genreId = $movie['mediaGenres'];
        $directorId = $movie['mediaDirectors'];
        $actorId = $movie['mediaActors'];

        if (!check_if_exists('medias', 'mediaId', $id, $conn)) {
            try {
                $sql = "INSERT INTO medias (mediaId, mediaTypeId, mediaName, mediaDescription, mediaPublishingDate, mediaYear, mediaCoverImage, mediaBackgroundImage) VALUES (:mediaId, :mediaTypeId, :mediaName, :mediaDescription, :mediaPublishingDate, :mediaYear, :mediaCoverImage, :mediaBackgroundImage)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':mediaId', $id);
                $stmt->bindParam(':mediaTypeId', $type);
                $stmt->bindParam(':mediaName', $title);
                $stmt->bindParam(':mediaDescription', $description);
                $stmt->bindParam(':mediaPublishingDate', $releaseDate);
                $stmt->bindParam(':mediaYear', $year);
                $stmt->bindParam(':mediaCoverImage', $picture);
                $stmt->bindParam(':mediaBackgroundImage', $backdropPicture);
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

        for ($j = 0; $j < count($directorId); $j++) {
            $director = $directorId[$j];
            try {
                $sql = "INSERT INTO appartient_author (appartientAuthorId, appartientMediaId) VALUES (:authorId, :mediaId)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':mediaId', $id);
                $stmt->bindParam(':authorId', $director);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            echo json_encode(array('status' => 'success -> Directors related to movie'));
        }

        for ($j = 0; $j < count($actorId[0]); $j++) {
            $actor = $actorId[0][$j];
            $character = $actorId[1][$j];
            try {
                $sql = "INSERT INTO appartient_actor (appartientActor_ID, appartientMedia_ID, actorCharacterName) VALUES (:actorId, :mediaId, :character)";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':mediaId', $id);
                $stmt->bindParam(':actorId', $actor);
                $stmt->bindParam(':character', $character);
                $stmt->execute();
            } catch (PDOException $e) {
                echo $e->getMessage();
            }

            echo json_encode(array('status' => 'success -> Actors related to movie'));
        }
    }
}
