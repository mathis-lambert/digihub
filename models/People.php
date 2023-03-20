<?php

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
}
