<?php
use Views\View;

require_once './config.php';
require_once './routes.php';

try {
    $routes = new Routes();
} catch (Exception $e) {
    $view = new View();
    $view->renderPage('error.php', [
        'Message' => $e->getMessage(),
        'Code' => $e->getCode()
    ]);
}?>