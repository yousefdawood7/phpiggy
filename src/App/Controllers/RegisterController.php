<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\ValidatorService;
use Framework\TemplateEngine;

class RegisterController {
    public function __construct(
        private TemplateEngine $view,
        private ValidatorService $validatorService
    ) {
    }

    public function registerView() {
        echo $this->view->render('register.php', [
            'title' => 'Register Page'
        ]);
    }

    public function register() {
        dd($_POST);
    }
}
