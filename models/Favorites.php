<?php

class Favorites
{

    public $favoriteMediaId;
    public $favoriteUserId;

    public function __construct($favoriteMediaId, $favoriteUserId)
    {
        $this->favoriteMediaId = $favoriteMediaId;
        $this->favoriteUserId = $favoriteUserId;
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

    public static function find($favoriteMediaId, $favoriteUserId)
    {
        $db = Db::getInstance();
        $favoriteUserId = intval($favoriteUserId);
        $favoriteMediaId = intval($favoriteMediaId);
        $req = $db->prepare('SELECT * FROM favorites WHERE favoriteUserId = :favoriteUserId AND favoriteMediaId = :favoriteMediaId');
        $req->execute(array('favoriteUserId' => $favoriteUserId, 'favoriteMediaId' => $favoriteMediaId));
        $favorite = $req->fetch(PDO::FETCH_ASSOC);


        if ($favorite) {
            return new Favorites($favorite['favoriteId'], $favorite['favoriteMediaId'], $favorite['favoriteUserId']);
        } else {
            return null;
        }
    }

    public static function add($favoriteMediaId, $favoriteUserId)
    {
        $db = Db::getInstance();
        $req = $db->prepare('INSERT INTO favorites (favoriteMediaId, favoriteUserId) VALUES (:favoriteMediaId, :favoriteUserId)');
        $req->execute(array('favoriteMediaId' => $favoriteMediaId, 'favoriteUserId' => $favoriteUserId));
        $favorite = Favorites::find($favoriteMediaId, $favoriteUserId);
        return $favorite;
    }

    public static function remove($favoriteMediaId, $favoriteUserId)
    {
        $db = Db::getInstance();
        $req = $db->prepare('DELETE FROM favorites WHERE favoriteMediaId = :favoriteMediaId AND favoriteUserId = :favoriteUserId');
        $req->execute(array('favoriteMediaId' => $favoriteMediaId, 'favoriteUserId' => $favoriteUserId));
    }
}
