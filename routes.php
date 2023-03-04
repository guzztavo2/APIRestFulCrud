<?php

use Controllers\crudController;
use Controllers\homeController;
use Controllers\userController;

class Routes
{
    private array $URL;
    public const HOME_PATH = HOME_URL;
    private const LIST_PAGE_REDIRECIONAMENTO = ['home', 'user', 'sobre', 'code', 'style'];
    private const GET_REQUISICOES = ['item'];
    public string $requestMethod;

    private function verificarTipoRequest()
    {
        new Models\informacao();
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $this->requestMethod = $requestMethod;
        userController::verificarTokenUser();
        switch ($requestMethod) {
            case 'POST':
                $this->redirecionamentoPOSTmethod();
                return;
                break;
            case 'GET':
                $this->redirecionamentoGETmethod();
                return;
                break;
            case 'UPDATE':
                return;
                break;

            case 'DELETE':
                return;
                break;

            default:
                throw new Exception('Esse método não é permitido', 400);
        }
    }

    public function redirecionamentoPOSTmethod()
    {
        $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        switch ($this->getURL()[0]) {
            case 'user':
                if ($this->getURL()[1] == 'criarConta')
                    userController::criarConta($_POST);
                if ($this->getURL()[1] == 'acessarConta')
                    userController::acessarConta($_POST);
                if ($this->getURL()[1] == 'verificarsenha')
                    userController::verificarSenha($_POST);
                if ($this->getURL()[1] == 'trocarSenha')
                    userController::trocarSenha($_POST);


                break;
        }
        exit;
    }
    public function __construct()
    {


        $this->setURL();
        $this->verificarTipoRequest();
    }

    private function setURL()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('/', $url);
        if (strlen($url[2]) == 0)
            unset($url[2]);

        array_splice($url, 0, 2);

        $this->URL = $url;
    }
    public function getURL()
    {
        return $this->URL;
    }

    public static function getLocalUrl()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('/', $url);
        if (strlen($url[2]) == 0)
            unset($url[2]);

        array_splice($url, 0, 2);

        return $url;
    }
    private function redirecionamentoGETmethod()
    {
        if (count($this->getURL()) == 0)
            self::redirecionarURL('home');

        $_GET = filter_input_array(INPUT_GET, FILTER_DEFAULT);


        foreach (self::LIST_PAGE_REDIRECIONAMENTO as $page) {
            if ($this->getURL()[0] === $page) {
                switch ($page) {
                    case 'home':
                        homeController::home();
                        break;
                    case 'sobre':
                        homeController::sobre();
                        break;
                    case 'errorequisicao':
                        throw new Exception('Não é possivel utilizar esse tipo de requisição.', 404);
                    case 'user':
                        if (count($this->getURL()) > 2)
                            throw new Exception('Não é possivel localizar essa página', 404);
                        //$user_url = ['criar', 'logar', 'conta', 'configuracao', 'sair'];
                        $urlNow = $this->getURL()[1];
                        if (strpos($this->getURL()[1], '?') !== false) {
                            $urlNow = substr($this->getURL()[1], 0, strpos($this->getURL()[1], '?'));
                            foreach (array_keys($_GET) as $item) {
                                if (array_search($item, self::GET_REQUISICOES) == false)
                                    self::redirecionarURL('errorequisicao');
                            }
                        }
                        switch ($urlNow) {
                            case 'criar':
                                userController::Create();
                                break;
                            case 'logar':
                                userController::Login();
                                break;
                            case 'conta':
                                userController::mainConta();
                                break;
                            case 'configuracao':
                                userController::configuracao();
                                break;
                            case 'trocarsenha':
                                userController::trocarSenha();
                            case 'app':
                                crudController::app();
                                break;
                            case 'sair':
                                userController::logout();
                                break;


                            default:
                                throw new Exception('Não é possivel localizar essa página', 404);
                        }
                        break;

                        // case 'code':
                        //     self::includeFile($this->getURL()[0], $this->getURL()[1]);
                        //     break;

                        // case 'style':
                        //     self::includeFile($this->getURL()[0], $this->getURL()[1]);

                        //     break;
                    default:
                        throw new Exception('Erro, essa URL não existe', 404);
                        break;
                }
            }
        }
        throw new Exception('Página não localizada', 404);
    }
    // private static function includeFile($typeFile, $nameFile)
    // {
    //     if ($typeFile == 'code')
    //         self::includeScriptFile($typeFile, $nameFile);
    //     else if ($typeFile == 'style')
    //         self::includeScriptFile($typeFile, $nameFile);
    // }
    // private static function includeScriptFile($typeFile, $nameFile)
    // {
    //     $FILES_DIR = 'VIEWS\public\\';

    //     $filesDir = scandir($FILES_DIR . $typeFile);
    //     array_splice($filesDir, 0, 2);

    //     if ($typeFile == 'code')
    //         header('content-type: text/javascript');
    //     else if ($typeFile == 'style')
    //         header('content-type: text/css');

    //     foreach ($filesDir as $file) {
    //         if ($file === $nameFile) {
    //             if (file_exists($FILES_DIR . '\\' . $typeFile . '\\' . $nameFile)) {
    //                 include($FILES_DIR .  '\\' . $typeFile . '\\' . $nameFile);
    //                 exit;
    //             } else
    //                 throw new Exception('Esse diretório não existe, verifique seu diretório e tente novamente.', 404);
    //         }
    //     }
    //     throw new Exception('Esse arquivo não existe, verifique seu diretório e tente novamente.', 404);
    // }
    public static function redirecionarURL($url)
    {
        header('location: ' . self::HOME_PATH . $url);
        exit;
    }
}
