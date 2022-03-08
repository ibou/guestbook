<?php

declare(strict_types=1);

namespace App\Message;

class CommentMessage
{
    /**
     * @param array<int,string> $context
     */
    public function __construct(private readonly int $id, private readonly string $reviewUrl, private array $context = [])
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getReviewUrl(): string
    {
        return $this->reviewUrl;
    }

    /**
     * @return array<int,string> $context
     */
    public function getContext(): array
    {
        return $this->context;
    }
}
