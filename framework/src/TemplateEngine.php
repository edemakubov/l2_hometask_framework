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

    /**
     * @param string $template
     * @param array $variables
     * @return string
     */
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
        $content = preg_replace_callback('/{{\s*include\s+([a-zA-Z0-9_\/]+)\s*}}/', function ($matches) use ($variables) {
            return $this->render($matches[1], $variables);
        }, $content);

        // Include header and footer templates if they exist
        $header = $this->includeTemplate('header');
        $footer = $this->includeTemplate('footer');

        return $header . $content . $footer;
    }

    /**
     * Include a template file and return its content
     *
     * @param string $template
     * @return string
     */
    private function includeTemplate(string $template): string
    {
        $templatePath = $this->templateDir . '/' . $template . '.php';
        if (file_exists($templatePath)) {
            ob_start();
            include $templatePath;
            return ob_get_clean();
        }
        return '';
    }
}