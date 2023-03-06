<?php

namespace Controllers;

use Models\informacao;
use Routes;
use Models\dataBase;
use Models\user;
class informacaoController extends Controller
{
    private static function validarRequisicao():user{
        $auth = apache_request_headers()['Authorization'];
        $contentType = apache_request_headers()['Content-Type'];
        $auth = substr($auth, 7);
        $user = user::buscarAPIToken($auth);
        if($user == false)
        exit('Não é possivel validar essa API Key, por favor, crie sua conta de usuário e tente novamente.');
        if($contentType !== 'application/json')
        exit('O servidor aceita apenas requisições do tipo JSON.');
        return $user;
    }
    public static function inserirInformacao($postData):void{
       $user = self::validarRequisicao();
       $informacao = file_get_contents('php://input');
        $informacao = json_decode($informacao);
        $informacao = new informacao();
        $informacao = $informacao::novaInformacao('asdasd', $user);
        //var_export($informacao);
        exit;
    }

}