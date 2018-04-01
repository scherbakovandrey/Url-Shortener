<?php

namespace App\Tests\Controller;

use App\Entity\Url;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class UrlShortenerControllerTest extends WebTestCase
{
    public function testEmptyUrl()
    {
        $messages = $this->submitWrongUrl('');
        $this->assertSame('Unable to shorten the entered URL', $messages['alertMessage']);
        $this->assertSame('The url should not be blank', $messages['errorMessage']);
    }

    /**
     * @dataProvider getUrlsWithWrongFormat
     */
    public function testWrongUrlFormat($url)
    {
        $messages = $this->submitWrongUrl($url);
        $this->assertSame('Unable to shorten the entered URL', $messages['alertMessage']);
        $this->assertSame('The url is not valid', $messages['errorMessage']);
    }

    public function testSelfServerUrl()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/');

        $request = $client->getRequest();
        $homePageUri = $request->getUri();

        $form = $crawler->selectButton('Shorten')->form([
            'url_shorten[originalUrl]' => $homePageUri . '3zLVS7',
        ]);
        $crawler = $client->submit($form);

        $alertMessage = trim($crawler->filter('.alert-danger')->text());
        $errorMessage = trim($crawler->filter('.help-block')->text());

        $this->assertSame('Unable to shorten the entered URL', $alertMessage);
        $this->assertSame('This url is already shorten', $errorMessage);
    }

    private function submitWrongUrl($url)
    {
        $client = static::createClient();

        $client->followRedirects();

        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('Shorten')->form([
            'url_shorten[originalUrl]' => $url,
        ]);
        $crawler = $client->submit($form);

        $alertMessage = trim($crawler->filter('.alert-danger')->text());
        $errorMessage = trim($crawler->filter('.help-block')->text());

        return [
            'alertMessage' => $alertMessage,
            'errorMessage' => $errorMessage
        ];
    }

    public function testExistingUrl()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('Shorten')->form([
            'url_shorten[originalUrl]' => 'https://symfony.com/',
        ]);
        $crawler = $client->submit($form);

        $shortenUrlBlockHref = $crawler->filter('.url')->filter('a')->attr('href');

        $this->assertTrue((bool)preg_match('/\/3zLVS7$/', $shortenUrlBlockHref, $matches));

        $originalUrlBlockText = $crawler->filter('.original-url')->text();
        $this->assertSame('Original URL: https://symfony.com/', $originalUrlBlockText);
    }

    public function testNewUrl()
    {
        $client = static::createClient();
        $client->followRedirects();

        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('Shorten')->form([
            'url_shorten[originalUrl]' => 'https://symfony.com/what-is-symfony',
        ]);
        $crawler = $client->submit($form);

        $originalUrlBlockText = $crawler->filter('.original-url')->text();
        $this->assertSame('Original URL: https://symfony.com/what-is-symfony', $originalUrlBlockText);
    }

    public function getUrlsWithWrongFormat()
    {
        yield ['http:/google.com'];
        yield ['http:// google.com'];
    }
}