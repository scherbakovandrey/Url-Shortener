<?php

namespace App\Tests\Utils;

use App\Utils\KeyGenerator;
use PHPUnit\Framework\TestCase;

class KeyGeneratorTest extends TestCase
{
    public function testKeyFormat()
    {
        for ($i = 0; $i < 1000; $i++)
        {
            $this->assertTrue((bool)preg_match('/^[A-Za-z0-9]{6}$/', KeyGenerator::generate()));
        }
    }
}
