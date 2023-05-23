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

    public static function find($favoriteUserId, $favoriteMediaId)
    {
        $db = Db::getInstance();
        $favoriteUserId = intval($favoriteUserId);
        $favoriteMediaId = intval($favoriteMediaId);
        $req = $db->prepare('SELECT * FROM favorites WHERE favoriteUserId = :favoriteUserId AND favoriteMediaId = :favoriteMediaId');
        $req->execute(array('favoriteUserId' => $favoriteUserId, 'favoriteMediaId' => $favoriteMediaId));
        $favorite = $req->fetch();

        if ($favorite) {
            return new Favorites($favorite['favoriteid'], $favorite['favoriteMediaId'], $favorite['favoriteUserId']);
        } else {
            return null;
        }
    }

    public static function add($favoriteMediaId, $favoriteUserId)
    {
        $db = Db::getInstance();
        $req = $db->query('INSERT INTO favorites (favoriteMediaId, favoriteUserId) VALUES (:favoriteMediaId, :favoriteUserId)');
        $req->execute(array('favoriteMediaId' => $favoriteMediaId, 'favoriteUserId' => $favoriteUserId));
    }

    public static function delete($favoriteMediaId, $favoriteUserId)
    {
        $db = Db::getInstance();
        $req = $db->query('DELETE FROM favorites WHERE favoriteMediaId = :favoriteMediaId AND favoriteUserId = :favoriteUserId');
        $req->execute(array('favoriteMediaId' => $favoriteMediaId, 'favoriteUserId' => $favoriteUserId));
    }
}
