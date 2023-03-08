<?php
include_once './models/Media.php';
include_once './models/Db.php';
include_once './models/User.php';

class Model
{
    public function getConn()
    {
        return Db::getInstance()->getConnection();
    }

    public function getMedia($id)
    {
        $sql = "SELECT * FROM medias, peoples, genres, types, appartient_genre, appartient_media WHERE medias.mediaTypeId = types.typeID AND medias.mediaId = appartient_media._mediaId  AND appartient_media._peopleId = peoples.peopleId AND medias.mediaId = appartient_genre.appartientMediaId AND genres.genreId = appartient_genre.appartientGenreId AND medias.mediaID = $id";
        $result = $this->getConn()->prepare($sql);
        $result->execute();
        $medias = $result->fetchAll(PDO::FETCH_ASSOC);

        $media = $this->getMediaFromResult($medias);

        $media = new Media($media['mediaId'], $media['mediaName'], $media['mediaYear'], $media['mediaDescription'], $media['mediaCoverImage'], $media['mediaBackgroundImage'],   $media['mediaPublishingDate'], $media['directors'], $media['actors'], $media['genres'], $media['typeName']);
        return $media;
    }

    public function getMediaFromResult($medias)
    {
        $media = null;
        $genres = [];
        $actors = [];
        $directors = [];
        foreach ($medias as $media) {
            if (!in_array($media['genreId'], $genres)) {
                $genres[$media['genreId']] = $media['genreName'];
            }
            if ($media['_departmentName'] == 'Actor') {
                if (!in_array($media['peopleId'], $actors)) {
                    $actors[$media['peopleId']] = [
                        'peopleId' => $media['peopleId'],
                        'peopleFullname' => $media['peopleFullname'],
                        'characterName' => $media['characterName'],
                        'peoplePicture' => $media['peoplePicture']
                    ];
                }
            } else if ($media['_departmentName'] == 'Director') {
                if (!in_array($media['peopleId'], $directors)) {
                    $directors[$media['peopleId']] = [
                        'peopleId' => $media['peopleId'],
                        'peopleFullname' => $media['peopleFullname'],
                        'peoplePicture' => $media['peoplePicture']
                    ];
                }
            }
        }
        $genres = array_values($genres);
        $media = $medias[0];
        $media['actors'] = json_encode($actors);
        $media['directors'] = json_encode($directors);
        $media['genres'] = json_encode($genres);
        // var_dump($media);
        return $media;
    }

    public function getMediasFromSearch($q)
    {
    }
}
