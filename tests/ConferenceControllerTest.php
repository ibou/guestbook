<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class ConferenceControllerTest extends PantherTestCase
{

    public function testIndex(): void
    {
        // $client = static::createClient();
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

        $this->assertSelectorTextContains('h2', 'Give your feedback!');
    }


    public function testCommentSubmission(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/conference/amsterdam-2019');
        $form = [
            'comment_form[author]' => 'Fabien',
            'comment_form[text]' => 'I am a comment',
            'comment_form[email]' => 'test@email.com',
            'comment_form[photo]' => \dirname(__DIR__, 2) . '/public/images/under-construction.gif',
        ];
        $client->submitForm('Submit', $form);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('div:contains("There are 3 comments")');
    }

    public function testConferencePage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertCount(2, $crawler->filter('h4'));
        // $client->clickLink('View');
        $client->click($crawler->filter('a')->link());
        $this->assertPageTitleContains('Amsterdam');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Amsterdam');
        $this->assertSelectorExists('div:contains("There are 2 comments")');
    }
}
