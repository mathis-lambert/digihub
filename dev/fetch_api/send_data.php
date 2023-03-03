<?php
require './config/config.php';
//get json body
$json = file_get_contents('php://input');
//decode json
$json = json_decode($json, true);

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
    }
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

        for ($j = 0; $j < count($genreId); $j++) {
            $genre = $genreId[$j];
            $sql = "INSERT INTO appartient_genre (appartientGenreId, appartientMediaId) VALUES (:genreId, :mediaId)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':mediaId', $id);
            $stmt->bindParam(':genreId', $genre);
            $stmt->execute();
        }

        for ($j = 0; $j < count($directorId); $j++) {
            $director = $directorId[$j];
            $sql = "INSERT INTO appartient_author (appartientAuthorId, appartientMediaId) VALUES (:authorId, :mediaId)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':mediaId', $id);
            $stmt->bindParam(':authorId', $director);
            $stmt->execute();
        }
    }
}
