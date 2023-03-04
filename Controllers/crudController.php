<?php

namespace Controllers;

use Routes;

class crudController extends Controller
{
    public static function app()
    {
        userController::verificarLogadoRedirect();
        $listInformacoes = [];
        self::includeFile('appCrud.php', ['listaInfo' => $listInformacoes]);
    }
}
