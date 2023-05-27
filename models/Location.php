<?php
include_once 'Db.php';

class Location
{
    public int $user_id;
    public int $media_id;
    public string $date_start;
    public string $date_end;

    public function __construct(int $user_id, int $media_id, string $date_start, string $date_end)
    {
        $this->user_id = $user_id;
        $this->media_id = $media_id;
        $this->date_start = $date_start;
        $this->date_end = $date_end;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getMediaId()
    {
        return $this->media_id;
    }

    public function getDateStart()
    {
        return $this->date_start;
    }

    public function getDateEnd()
    {
        return $this->date_end;
    }

    public function add()
    {
        $db = new Db();
        $query = $db->query('INSERT INTO location (user_id, media_id, date_start, date_end) VALUES (?, ?, ?, ?)');
        $query->execute([$this->user_id, $this->media_id, $this->date_start, $this->date_end]);
        return $query;
    }
}
