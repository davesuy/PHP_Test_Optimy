<?php

require_once(ROOT . '/utils/DB.php');
require_once(ROOT . '/utils/CommentManager.php');
require_once(ROOT . '/class/News.php');

class NewsManager
{
    private static $instance = null;
    private $db;
    private $commentManager;

    private function __construct($db, $commentManager)
    {
        $this->db = $db;
        $this->commentManager = $commentManager;
    }

    public static function getInstance($db, $commentManager)
    {
        if (null === self::$instance) {
            self::$instance = new self($db, $commentManager);
        }
        return self::$instance;
    }

    public function listNews()
    {
        $rows = $this->db->select('SELECT * FROM `news`');
        $news = [];
        foreach ($rows as $row) {
            $news[] = (new News())
                ->setId($row['id'])
                ->setTitle($row['title'])
                ->setBody($row['body'])
                ->setCreatedAt($row['created_at']);
        }
        return $news;
    }

    public function addNews($title, $body)
    {
        $sql = "INSERT INTO `news` (`title`, `body`, `created_at`) VALUES(:title, :body, :created_at)";
        $params = [
            ':title' => $title,
            ':body' => $body,
            ':created_at' => date('Y-m-d')
        ];
        $this->db->exec($sql, $params);
        return $this->db->lastInsertId();
    }

    public function deleteNews($id)
    {
        $comments = $this->commentManager->listComments();
        foreach ($comments as $comment) {
            if ($comment->getNewsId() == $id) {
                $this->commentManager->deleteComment($comment->getId());
            }
        }
        $sql = "DELETE FROM `news` WHERE `id` = :id";
        $params = [':id' => $id];
        return $this->db->exec($sql, $params);
    }
}