<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Config\Paths;

use Framework\TemplateEngine;

class AboutController {
    private TemplateEngine $view;

    public function __construct() {
        $this->view = new TemplateEngine(Paths::VIEW);
    }

    public function about() {
        echo $this->view->render('about.php', [
            'title' => 'About',
            'dan' => '<script>alert("YD7")</script>'
        ]);
    }
}
