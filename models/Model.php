<?php
include_once './models/Media.php';
include_once './models/People.php';
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
      if ($medias) {
         $media = $this->getMediaFromResult($medias);
         $media = new Media($media['mediaId'], $media['mediaName'], $media['mediaYear'], $media['mediaDescription'], $media['mediaCoverImage'], $media['mediaBackgroundImage'], $media['mediaVideoLink'], $media['mediaPublishingDate'], $media['directors'], $media['actors'], $media['genres'], $media['typeName']);
         return $media;
      }
      return null;
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

   public function getGenres()
   {
      $sql = "SELECT * FROM genres";
      $result = $this->getConn()->prepare($sql);
      $result->execute();
      $genres = $result->fetchAll(PDO::FETCH_ASSOC);
      return $genres;
   }

   public function getNewMedias($type)
   {
      $sql = "SELECT * FROM medias, types WHERE medias.mediaTypeId = types.typeID AND types.typeName = '$type' ORDER BY medias.mediaPublishingDate DESC LIMIT 27";
      $result = $this->getConn()->prepare($sql);
      $result->execute();
      $medias = $result->fetchAll(PDO::FETCH_ASSOC);
      return $medias;
   }

   public function getPeople($id)
   {
      $sql = "SELECT * FROM peoples, appartient_media, medias, types WHERE peoples.peopleId = appartient_media._peopleId AND appartient_media._mediaId = medias.mediaId AND medias.mediaTypeId = types.typeID AND peoples.peopleId = $id";
      $result = $this->getConn()->prepare($sql);
      $result->execute();
      $people = $result->fetch(PDO::FETCH_ASSOC);
      if ($people) {
         $people = new People($people['peopleId'], $people['peopleFirstname'], $people['peopleLastname'], $people['peopleFullname'], $people['peopleBirthday'], $people['peopleDeathday'], $people['peopleBiography'], $people['peoplePicture'], $people['peopleBirthplace'], $people['peopleKnownForDepartment']);
         return $people;
      }
      return null;
   }


   public function getMediasFromSearch($q)
   {
   }

   public function getOwnSuggestion()
   {
      $sql = "SELECT * FROM medias, genres, types, appartient_genre WHERE medias.mediaTypeId = types.typeID AND medias.mediaId = appartient_genre.appartientMediaId AND appartient_genre.appartientGenreId = genres.genreId ORDER BY RAND() LIMIT 3";
      $result = $this->getConn()->prepare($sql);
      $result->execute();
      $results = $result->fetchAll(PDO::FETCH_ASSOC);
      if ($results) {
         $medias = [];
         foreach ($results as $media) {
            //$media = new Media($media['mediaId'], $media['mediaName'], $media['mediaYear'], $media['mediaDescription'], $media['mediaCoverImage'], $media['mediaBackgroundImage'],   $media['mediaPublishingDate'], [], [], $media['genre'], $media['typeName']);
            $medias[] = $media;
         }
         return $medias;
      }
      return null;
   }

   public function getUserByName($userFirstname)
   {
      $db = Db::getInstance();
      $req = $db->prepare('SELECT * FROM users WHERE userFirstname = :userFirstname');
      $req->execute(array('userFirstname' => $userFirstname));
      $user = $req->fetch();

      return new User($user['userId'], $user['userFirstname'], $user['userLastname'], $user['userBirthdate'], $user['userMail'], $user['userPassword'], $user['userCreationDate'], $user['userFavoriteMediaType'], $user['userFavoriteBookTag'], $user['userFavoriteMovieTag']);
   }

   public function getMediaTypeNameById($mediaTypeId)
   {
      $sql = "SELECT * FROM types WHERE typeID = $mediaTypeId";
      $result = $this->getConn()->prepare($sql);
      $result->execute();
      $type = $result->fetch(PDO::FETCH_ASSOC);
      return $type['typeName'];
   }

   public function getFilmWithFilter($filter)
   {
      $sql = "SELECT * FROM medias, types WHERE medias.mediaTypeId = types.typeID AND types.typeName = 'Film'";
      if ($filter['year']) {
         $sql .= " AND medias.mediaYear = " . $filter['year'];
      }
      if ($filter['genre']) {
         $sql .= " AND medias.mediaId IN (SELECT appartient_media._mediaId FROM appartient_media, appartient_genre WHERE appartient_media._mediaId = appartient_genre.appartientMediaId AND appartient_genre.appartientGenreId = " . $filter['genre'] . ")";
      }
      if ($filter['director']) {
         $sql .= " AND medias.mediaId IN (SELECT appartient_media._mediaId FROM appartient_media, peoples WHERE appartient_media._peopleId = peoples.peopleId AND peoples.peopleId = " . $filter['director'] . ")";
      }
      if ($filter['actor']) {
         $sql .= " AND medias.mediaId IN (SELECT appartient_media._mediaId FROM appartient_media, peoples WHERE appartient_media._peopleId = peoples.peopleId AND peoples.peopleId = " . $filter['actor'] . ")";
      }
      $result = $this->getConn()->prepare($sql);
      $result->execute();
      $medias = $result->fetchAll(PDO::FETCH_ASSOC);
      return $medias;
   }
}
