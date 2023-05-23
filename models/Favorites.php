<?php

class Favorites
{
    public $favoriteid;
    public $favoriteMediaId;
    public $favoriteUserId;

    public function __construct($favoriteid, $favoriteMediaId, $favoriteUserId)
    {
        $this->favoriteid = $favoriteid;
        $this->favoriteMediaId = $favoriteMediaId;
        $this->favoriteUserId = $favoriteUserId;
    }

    public function getFavoriteId()
    {
        return $this->favoriteid;
    }

    public function getFavoriteMediaId()
    {
        return $this->favoriteMediaId;
    }

    public function getFavoriteUserId()
    {
        return $this->favoriteUserId;
    }

    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM favorites');

        foreach ($req->fetchAll() as $favorite) {
            $list[] = new Favorites($favorite['favoriteid'], $favorite['favoriteMediaId'], $favorite['favoriteUserId']);
        }

        return $list;
    }
}
