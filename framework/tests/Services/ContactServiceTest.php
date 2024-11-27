<?php
declare(strict_types=1);

namespace Tests\Services;

use PHPUnit\Framework\TestCase;

class ContactServiceTest extends TestCase
{
    public function testIndex()
    {
        $this->assertEquals('Contact Service Index', 'Contact Service Index');
    }
}
