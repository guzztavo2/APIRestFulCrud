<?php
namespace Controllers;

use Views\view;

class Controller{
    private static view $ViewConstructor;

    protected static function includeFile($fileName, array $dataArray = null){
        self::$ViewConstructor = new view();
        if($dataArray === null)
        self::$ViewConstructor->renderPage($fileName);
        else
        self::$ViewConstructor->renderPage($fileName, $dataArray);
        exit;
    
    }
}