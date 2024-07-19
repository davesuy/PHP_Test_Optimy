<?php

class Comment extends AbstractBaseEntity
{
    protected int $newsId;

    public function setNewsId(int $newsId): self
    {
        $this->newsId = $newsId;
        return $this;
    }

    public function getNewsId(): int
    {
        return $this->newsId;
    }
}

