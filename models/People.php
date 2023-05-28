<?php
include_once 'Db.php';

class People
{
    public $peopleId;
    public $peopleFirstname;
    public $peopleLastname;
    public $peopleFullname;
    public $peopleBirthday;
    public $peopleDeathday;
    public $peopleBiography;
    public $peoplePicture;
    public $peopleBirthplace;
    public $peopleKnownForDepartment;

    public function __construct($peopleId, $peopleFirstname, $peopleLastname, $peopleFullname, $peopleBirthday, $peopleDeathday, $peopleBiography, $peoplePicture, $peopleBirthplace, $peopleKnownForDepartment)
    {
        $this->peopleId = $peopleId;
        $this->peopleFirstname = $peopleFirstname;
        $this->peopleLastname = $peopleLastname;
        $this->peopleFullname = $peopleFullname;
        $this->peopleBirthday = $peopleBirthday;
        $this->peopleDeathday = $peopleDeathday;
        $this->peopleBiography = $peopleBiography;
        $this->peoplePicture = $peoplePicture;
        $this->peopleBirthplace = $peopleBirthplace;
        $this->peopleKnownForDepartment = $peopleKnownForDepartment;
    }

    public function getPeopleId()
    {
        return $this->peopleId;
    }

    public function getFilms()
    {
        $db = Db::getInstance();
        $sql = "SELECT * FROM medias, appartient_media, peoples WHERE medias.mediaId = appartient_media._mediaId AND appartient_media._peopleId = peoples.peopleId AND peoples.peopleId = :peopleId GROUP BY medias.mediaId";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':peopleId', $this->peopleId);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
}
