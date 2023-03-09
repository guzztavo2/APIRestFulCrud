<?php

use Controllers\homeController;
use Controllers\userController;
use Controllers\informacaoController;

class Routes
{
    private array $URL;
    public const HOME_PATH = HOME_URL;
    private const LIST_PAGE_REDIRECIONAMENTO = ['home', 'user', 'sobre', 'informacao'];
    private const GET_REQUISICOES = ['app' => ['page']];
    public string $requestMethod;

    private function verificarTipoRequest(string $metodoHttp)
    {
        $this->verificarTokenUser();
    
        $metodosSuportados = [
            'POST' => 'redirecionamentoPOSTmethod',
            'GET' => 'redirecionarGETmethod',
            'PUT' => 'redirecionarPutMethod',
            'DELETE' => 'redirecionarDeleteMethod',
        ];
    
        if (isset($metodosSuportados[$metodoHttp])) {
            $this->{$metodosSuportados[$metodoHttp]}();
            return;
        }
    
        throw new Exception('Esse método não é permitido', 400);
    }
    
    private function verificarTokenUser()
    {
        userController::verificarTokenUser();
    }
    
    public function redirecionarDeleteMethod()
    {
        if ($this->verificarUrlParaDeletarInformacao()) {
            informacaoController::deletarInformacao();
            return;
        }
    
        $this->responderRequisicaoNaoPermitida();
    }
    
    public function redirecionarPutMethod()
    {
        if ($this->verificarUrlParaAtualizarInformacao()) {
            informacaoController::atualizarInformacao();
            return;
        }
    
        $this->responderRequisicaoNaoPermitida();
    }
    
    private function verificarUrlParaDeletarInformacao()
    {
        $url = self::getLocalUrl();
        return ($url[0] == 'informacao' && $url[1] == 'deletarinformacao');
    }
    
    private function verificarUrlParaAtualizarInformacao()
    {
        $url = self::getLocalUrl();
        return ($url[0] == 'informacao' && $url[1] == 'atualizarinformacao');
    }
    
    private function responderRequisicaoNaoPermitida()
    {
        http_response_code(403);
        exit('Essa requisição não é permitida aqui!');
    }
    public function redirecionamentoPOSTmethod()
    {
        $postData = $this->filtrarDadosDeEntrada();

        $routes = [
            'user/criarConta' => ['controller' => 'userController', 'method' => 'criarConta'],
            'user/acessarConta' => ['controller' => 'userController', 'method' => 'acessarConta'],
            'user/verificarsenha' => ['controller' => 'userController', 'method' => 'verificarSenha'],
            'user/trocarSenha' => ['controller' => 'userController', 'method' => 'trocarSenha'],
            'informacao/inserirInformacao' => ['controller' => 'informacaoController', 'method' => 'inserirInformacao']
        ];

        $url = implode('/', $this->getURL());
        if (array_key_exists($url, $routes)) {
            $route = $routes[$url];
            $methodName = $route['method'];
            if ($route['controller'] == 'userController')
                userController::$methodName($postData);
            else
                informacaoController::inserirInformacao($postData);
        }

        exit;
    }

    private function filtrarDadosDeEntrada()
    {

        return filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    public function __construct()
    {
        $this->setURL();
        $this->verificarTipoRequest($_SERVER['REQUEST_METHOD']);
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
    private function redirecionarGETmethod()
    {
        // Filtra os parâmetros GET da URL
        $_GET = filter_input_array(INPUT_GET, FILTER_DEFAULT);

        $url = $this->getURL();
        $pagina = $url[0] ?? self::redirecionarURL('home');

        if (in_array($pagina, self::LIST_PAGE_REDIRECIONAMENTO)) {
            switch ($pagina) {
                case 'home':
                    homeController::home();
                    break;
                case 'sobre':
                    homeController::sobre();
                    break;
                case 'informacao':                    
                    informacaoController::informacao($url[1]);               
                    break;
                case 'errorequisicao':
                    throw new Exception('Não é possível utilizar esse tipo de requisição.', 404);
                case 'user':
                    $this->redirecionarUsuario($url);
                    break;
                default:
                    throw new Exception('Erro, essa URL não existe', 404);
                    break;
            }
        } else {
            throw new Exception('Página não localizada', 404);
        }
    }

    // Função auxiliar para redirecionamento de páginas de usuário
    private function redirecionarUsuario($url)
    {
        // Verifica se a URL de usuário tem mais de um elemento
        if (count($url) > 2) {
            throw new Exception('Não é possivel localizar essa página', 404);
        }

        $acao = $url[1];

        // Verifica se há parâmetros GET na URL e se são válidos
        if (strpos($acao, '?') !== false) {
            $acao = substr($acao, 0, strpos($acao, '?'));
            foreach (array_keys($_GET) as $parametro) {
                if (!in_array($parametro, self::GET_REQUISICOES[$acao])) {
                    self::redirecionarURL('errorequisicao');
                }
            }
        }

        // Redireciona para a ação de usuário correspondente
        switch ($acao) {
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
                informacaoController::app();
                break;
            case 'sair':
                userController::logout();
                break;
            default:
                throw new Exception('Não é possivel localizar essa página', 404);
                break;
        }
    }

    public static function redirecionarURL($url)
    {
        header('location: ' . self::HOME_PATH . $url);
        exit;
    }
}
