<?php

declare(strict_types=1);

namespace App\Middleware;

use Framework\TemplateEngine;
use Framework\Contracts\MiddlewareInterface;

class TemplateDataMiddleware implements MiddlewareInterface {
    public function __construct(private TemplateEngine $view) {
    }

    public function process(callable $next) {
        $this->view->addGlobal('title', 'Expenses Tracker');
        $next();
    }
}
