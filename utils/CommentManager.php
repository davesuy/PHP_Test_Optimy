<?php

require_once(ROOT . '/utils/DB.php');
require_once(ROOT . '/class/Comment.php');

class CommentManager
{
    private static $instance = null;
    private $db;

    private function __construct($db)
    {
        $this->db = $db;
    }

    public static function getInstance($db)
    {
        if (null === self::$instance) {
            self::$instance = new self($db);
        }
        return self::$instance;
    }

    public function listComments()
    {
        $rows = $this->db->select('SELECT * FROM `comment`');
        $comments = [];
        foreach ($rows as $row) {
            $comments[] = (new Comment())
                ->setId($row['id'])
                ->setBody($row['body'])
                ->setCreatedAt($row['created_at'])
                ->setNewsId($row['news_id']);
        }
        return $comments;
    }

    public function addCommentForNews($body, $newsId)
    {
        $sql = "INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES(:body, :created_at, :news_id)";
        $params = [
            ':body' => $body,
            ':created_at' => date('Y-m-d'),
            ':news_id' => $newsId
        ];
        $this->db->exec($sql, $params);
        return $this->db->lastInsertId();
    }

    public function deleteComment($id)
    {
        $sql = "DELETE FROM `comment` WHERE `id` = :id";
        $params = [':id' => $id];
        return $this->db->exec($sql, $params);
    }
}