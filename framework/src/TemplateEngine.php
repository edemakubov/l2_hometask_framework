<?php

declare(strict_types=1);

namespace Src;

class TemplateEngine
{
    private string $templateDir;

    public function __construct(string $templateDir)
    {
        $this->templateDir = $templateDir;
    }


    public function render(string $template, array $variables = []): string
    {
        $templatePath = $this->templateDir . '/' . $template . '.php';
        if (!file_exists($templatePath)) {
            throw new \RuntimeException("Template not found: $templatePath");
        }

        extract($variables, EXTR_SKIP);
        ob_start();
        include $templatePath;
        $content = ob_get_clean();

        // Handle nested templates
        return preg_replace_callback('/{{\s*include\s+([a-zA-Z0-9_\/]+)\s*}}/', function ($matches) use ($variables) {
            return $this->render($matches[1], $variables);
        }, $content);
    }
}