<?php

namespace App\Tests;

use App\Entity\Comment;
use App\Entity\Topics;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    private $topics;
    private $comment;

    public function setUp(): void
    {
        $this->topics = $this->createMock(Topics::class);
        $this->comment = new Comment();
    }

    public function testGetAndSetData(): void
    {
        $this->comment->setAuthor('Ivan');
        $this->comment->setText('Example text');
        $this->comment->setTopics($this->topics);

        $this->assertSame('Ivan', $this->comment->getAuthor());
        $this->assertSame('Example text', $this->comment->getText());
        $this->assertInstanceOf(Topics::class,$this->comment->getTopics());

    }
}
