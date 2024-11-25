<?php

declare(strict_types=1);

namespace Tests;

use App\Services\HomeService;
use PHPUnit\Framework\TestCase;

class IndexServiceTest extends TestCase
{
    public function testIndexReturnsHelloWorld()
    {
        $app = new HomeService();
        $this->assertEquals('Hello World', $app->index());
    }

    public function testAboutReturnsAboutIndex()
    {
        $app = new HomeService();
        $this->assertEquals('About Index', $app->about());
    }

    public function testIndexDontReturnHello()
    {
        $app = new HomeService();
        $this->assertNotEquals('Hello', $app->index());
    }
}