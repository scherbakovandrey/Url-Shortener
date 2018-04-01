<?php

namespace App\Tests\Utils;

use App\Utils\UrlFormatter;
use PHPUnit\Framework\TestCase;

class UrlFormatterTest extends TestCase
{
    public function testFormat()
    {
        $this->assertSame('', UrlFormatter::format(''));
        $this->assertSame('https://www.google.com/', UrlFormatter::format('https://www.google.com/'));
        $this->assertSame('http://symfony.com/', UrlFormatter::format('http://symfony.com/'));
        $this->assertSame('https://symfony.com/doc/current/components/dependency_injection.html', UrlFormatter::format('https://symfony.com/doc/current/components/dependency_injection.html'));
        $this->assertSame('https://symfony.com/doc/current/components/dependency_injection.html#avoiding-yo...', UrlFormatter::format('https://symfony.com/doc/current/components/dependency_injection.html#avoiding-your-code-becoming-dependent-on-the-container'));
    }
}
