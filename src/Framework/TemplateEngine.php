<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine {
    private array $globalTemplateData = [];

    public function __construct(private string $basePath) {
    }

    public function render(string $template, array $date = []): string | false {
        extract($date, EXTR_SKIP);
        extract($this->globalTemplateData, EXTR_SKIP);
        ob_start();
        include $this->resolve($template);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }

    public function resolve(string $path): string {
        return "{$this->basePath}/{$path}";
    }

    public function addGlobal(string $key, mixed $value) {
        $this->globalTemplateData[$key] = $value;
    }
}
