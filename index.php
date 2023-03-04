<?php
include('./config.php');
include('./routes.php');
use Views\view;
try{
$routes = new Routes();
}catch(Exception $e){   
    $view = new view();
    $view->renderPage('error.php', array('Message' => $e->getMessage(), 'Code' => $e->getCode()));
}

