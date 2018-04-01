<?php

namespace App\Tests\Controller;

use App\Entity\Url;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class RedirectControllerTest extends WebTestCase
{
    /**
     * @dataProvider getExistingUrls
     */
    public function testRedirectUrls($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
    }

    /**
     * @dataProvider getUrlsWithWrongFormat
     * @dataProvider getNotExistingUrls
     */
    public function testNotValidUrls($url)
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertSame(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }

    public function getExistingUrls()
    {
        yield ['/QjMp7D'];
        yield ['/3zLVS7'];
        yield ['/JlkcJn'];
    }

    public function getUrlsWithWrongFormat()
    {
        yield ['/4CmeB#'];
        yield ['/4CmeB'];
        yield ['/4CmeB_'];
        yield ['/4CmeBcO'];
        yield ['/4CmeBc1'];
        yield ['/4CmeBc/'];
    }

    public function getNotExistingUrls()
    {
        yield ['/QjMp7F'];
        yield ['/3zLTS7'];
        yield ['/JLkcJn'];
    }
}
