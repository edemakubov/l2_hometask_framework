<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Src\TemplateEngine;

class TemplateEngineTest extends TestCase
{
    private TemplateEngine $templateEngine;

    protected function setUp(): void
    {
        $this->templateEngine = new TemplateEngine(__DIR__ . '/templates');
    }

    public function testRenderTemplate(): void
    {
        $output = $this->templateEngine->render('test', ['name' => 'John']);
        $this->assertStringContainsString('Hello, John', $output);
    }

}