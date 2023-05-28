<?php
class Comments
{

    public $commentId;
    public $commentUserId;
    public $commentMediaId;
    public $commentText;
    public $commentRating;
    public $commentStatus;
    public $commentDate;

    public function __construct($commentId, $commentUserId, $commentMediaId, $commentText, $commentRating, $commentStatus, $commentDate)
    {
        $this->commentId = $commentId;
        $this->commentUserId = $commentUserId;
        $this->commentMediaId = $commentMediaId;
        $this->commentText = $commentText;
        $this->commentRating = $commentRating;
        $this->commentStatus = $commentStatus;
        $this->commentDate = $commentDate;
    }

    public function getCommentMediaId()
    {
        return $this->commentMediaId;
    }

    public function getCommentUserId()
    {
        return $this->commentUserId;
    }

    public static function all()
    {
        $list = [];
        $db = Db::getInstance();
        $req = $db->query('SELECT * FROM comments');

        foreach ($req->fetchAll() as $comment) {
            $list[] = new Comments($comment['commentid'], $comment['commentMediaId'], $comment['commentUserId'], $comment['commentText'], $comment['commentRating'], $comment['commentStatus'], $comment['commentDate']);
        }

        return $list;
    }

    public static function find($commentMediaId, $commentUserId)
    {
        $db = Db::getInstance();
        $commentUserId = intval($commentUserId);
        $commentMediaId = intval($commentMediaId);
        $req = $db->prepare('SELECT * FROM comments WHERE commentUserId = :commentUserId AND commentMediaId = :commentMediaId');
        $req->execute(array('commentUserId' => $commentUserId, 'commentMediaId' => $commentMediaId));
        $comment = $req->fetch(PDO::FETCH_ASSOC);


        if ($comment) {
            return new Comments($comment['commentId'], $comment['commentMediaId'], $comment['commentUserId'], $comment['commentText'], $comment['commentRating'], $comment['commentStatus'], $comment['commentDate']);
        } else {
            return null;
        }
    }

    public static function add($commentMediaId, $commentUserId, $commentText, $commentRating, $commentStatus, $commentDate)
    {
        $db = Db::getInstance();
        $req = $db->prepare('INSERT INTO comments (commentMediaId, commentUserId, commentText, commentRating, commentStatus, commentDate) VALUES (:commentMediaId, :commentUserId, :commentTitle, :commentText, :commentRating, :commentStatus, :commentDate)');
        $req->execute(array('commentMediaId' => $commentMediaId, 'commentUserId' => $commentUserId, 'commentText' => $commentText, 'commentRating' => $commentRating, 'commentStatus' => $commentStatus, 'commentDate' => $commentDate));
        $comment = Comments::find($commentMediaId, $commentUserId);
        return $comment;
    }

    public static function remove($commentMediaId, $commentUserId)
    {
        $db = Db::getInstance();
        $req = $db->prepare('DELETE FROM comments WHERE commentMediaId = :commentMediaId AND commentUserId = :commentUserId');
        $req->execute(array('commentMediaId' => $commentMediaId, 'commentUserId' => $commentUserId));
    }
}
