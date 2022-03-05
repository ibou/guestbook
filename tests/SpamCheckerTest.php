<?php

namespace App\Tests;

use App\SpamChecker;
use App\Entity\Comment;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SpamCheckerTest extends TestCase
{
    public function testSpamScoreWithInvalidRequest(): void
    {
        $comment = $this->getComment();
        $context = [];
        $mockResponse = new MockResponse('invalid', ['response_headers' => ['x-akismet-debug-help: Invalid key']]);
        $client = new MockHttpClient($mockResponse);
        $spamChecker = new SpamChecker($client, '5b23f90a24b9');
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Unable to check for spam: invalid (Invalid key).');
        $spamChecker->getSpamScore($comment, $context);
    }

    /**
     * @dataProvider getComments
     */
    public function testSpamScoreWithValidRequest(
        int $expectedScore,
        ResponseInterface $response,
        Comment $comment,
        array $context
    ): void {
        $client = new MockHttpClient([$response]);
        $spamChecker = new SpamChecker($client, '5b23f90a24b9');
        $score = $spamChecker->getSpamScore($comment, $context);
        $this->assertSame($expectedScore, $score);
    }

    public function getComments(): iterable
    {
        $comment = $this->getComment();
        $context = [];
        $response = new MockResponse('', ['response_headers' => ['x-akismet-pro-tip: discard']]);
        yield 'blatant_spam' => [2, $response, $comment, $context];

        $response = new MockResponse('true');
        yield 'spam' => [1, $response, $comment, $context];

        $response = new MockResponse('false');
        yield 'ham' => [0, $response, $comment, $context];
    }

    private function getComment(): Comment
    {
        $comment = new Comment();
        $comment->setCreatedAtValue();
        return $comment;
    }
}
