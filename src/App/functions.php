<?php

function dd(mixed $val) {
    echo '<pre>';
    var_dump($val);
    echo '</pre>';
    die();
}

function e(mixed $val): string {
    return htmlspecialchars((string)$val);
}
