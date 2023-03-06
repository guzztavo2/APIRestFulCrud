<?php

namespace Controllers;

use Exception;
use Models\informacao;
use Routes;
use Models\dataBase;
use Models\user;

class informacaoController extends Controller
{
    public static function app()
    {
        userController::verificarLogadoRedirect();
       
        $perPage = 8; // Quantidade de resultados por página
        $page = isset($_GET['page']) ? $_GET['page'] : 1; // Página atual, padrão é a primeira página
        $offset = ($page - 1) * $perPage; // Deslocamento necessário para a página atual
        
        $listItemPage = informacao::buscarPagina($perPage, $offset);
   

        $totalPages = ceil((int)count(informacao::getInformacaoList()) / $perPage);
       
        self::includeFile('appCrud.php', ['listaInfo' => $listItemPage,'paginaAtual' => $page, 'totalPages' => $totalPages]);
    }


    private static function validarRequisicao(): user
    {
        $headers = apache_request_headers();

        if (!isset($headers['Authorization']) || !isset($headers['Content-Type']) || $headers['Content-Type'] !== 'application/json') {
            http_response_code(400);
            exit('O servidor aceita apenas requisições do tipo JSON.');
        }

        $auth = substr($headers['Authorization'], 7);
        $user = user::buscarAPIToken($auth);

        if (!$user) {
            http_response_code(401);
            exit('Não é possível validar essa chave de API. Crie uma conta de usuário e tente novamente.');
        }

        return $user;
    }
    private static function filterJsonDecode()
    {
       
           
        $inputData = json_decode(file_get_contents('php://input'), true);
        $inputData = filter_var_array($inputData, FILTER_SANITIZE_SPECIAL_CHARS);
        
        if (count($inputData) > 10) {
            http_response_code(429);
            exit('Você está tentando enviar mais de 10 informações por essa requisição, por favor, diminua e tente novamente.');
        }
        
        return $inputData;
    }
    
    public static function inserirInformacao(): void
    {
        $user = self::validarRequisicao();
        
        $filteredData = self::filterJsonDecode();  

        $filteredData = array_map(function($item) use ($user) {
            $novaInformacao = informacao::novaInformacao($item['informacao'], $user);
            if($novaInformacao->salvar() == false){
                http_response_code(500);
                exit('Não está sendo possível salvar elementos no banco de dados no momento!');
            }
            $item['informacao'] = $novaInformacao;
            return $item;
        }, $filteredData);  
            
      
        // TODO: Salvar informação no banco de dados
    
        // Debug:
        exit;
    }
    public static function gerarUrl(string $page = null):string{
       
        if($page == null){
           return Routes::HOME_PATH.implode('/',Routes::getLocalUrl());
        }       
        return Routes::HOME_PATH.implode('/',Routes::getLocalUrl()).'?'.http_build_query(['page' => $page]);;

    }
    
}
