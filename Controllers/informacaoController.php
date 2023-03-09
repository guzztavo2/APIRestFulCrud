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
        $page = filter_var($page, FILTER_SANITIZE_NUMBER_INT);
        $offset = ($page - 1) * $perPage; // Deslocamento necessário para a página atual

        $listItemPage = informacao::buscarPagina($perPage, $offset);


        $totalPages = ceil((int)count(informacao::getInformacaoList()) / $perPage);

        self::includeFile('appCrud.php', ['listaInfo' => $listItemPage, 'paginaAtual' => $page, 'totalPages' => $totalPages]);
    }
    public static function informacao($idInfo)
    {
        userController::verificarLogadoRedirect();

        $idInfo = filter_var($idInfo, FILTER_VALIDATE_INT);
        if ($idInfo === false)
            throw new Exception('A informação requisitada não é válida.', 400);

        $idInfo = informacao::buscarPorID($idInfo);
        if ($idInfo == false)
            throw new Exception('Essa informação não é válida mais. Pois já foi deletada ou movida.', 404);
        
        self::includeFile('informacaoView.php', ['informacao' => $idInfo]);
        
    }
    public static function deletarInformacao()
    {
        self::validarRequisicao();

        $informacoes = self::filterJsonDecode();
        if (empty($informacoes) || count($informacoes) == 0) {
            http_response_code(204);
            exit('Nenhuma informação foi enviada para ser tratada.');
        }

        $idsInformacoes = [];
        foreach ($informacoes as $info) {
            if (isset($info['id'])) {
                $idsInformacoes[] = $info['id'];
            }
        }

        if (empty($idsInformacoes)) {
            http_response_code(204);
            exit('Nenhum id foi enviado para deletar as informações.');
        }

        $informacoesDeletadas = 0;
        foreach ($idsInformacoes as $id) {
            $informacao = informacao::buscarPorID($id);
            if ($informacao === false) {
                http_response_code(404);
                exit('Não foi encontrada nenhuma informação com o id enviado: ' . $id);
            }
            $informacao->deletarInformacao($id);

            $informacoesDeletadas++;
        }

        http_response_code(200);
        exit('Foram deletadas ' . $informacoesDeletadas . ' informações com sucesso!');
    }

    public static function atualizarInformacao()
    {
        self::validarRequisicao();

        $informacoes = self::filterJsonDecode();
        if (empty($informacoes) || count($informacoes) == 0) {
            http_response_code(204);
            exit('Nenhuma informação foi enviada para ser tratada.');
        }

        $informacoesAtualizadas = 0;
        foreach ($informacoes as $info) {
            if (!isset($info['id']) || !isset($info['novaInformacao'])) {
                http_response_code(204);
                exit('Algum dos campos obrigatórios não foi enviado.');
            }

            if (empty(trim($info['id'])) || empty(trim($info['novaInformacao']))) {
                http_response_code(204);
                exit('Algum dos campos possui valor inválido.');
            }

            $informacao = informacao::buscarPorID($info['id']);
            if ($informacao === false) {
                http_response_code(404);
                exit('Não foi encontrada nenhuma informação com o id enviado: ' . $info['id']);
            }
            $informacao->atualizarInformacao($info['novaInformacao']);

            $informacoesAtualizadas++;
        }

        http_response_code(200);
        exit('Foram atualizadas ' . $informacoesAtualizadas . ' informações com sucesso!');
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

        $filteredData = array_map(function ($item) use ($user) {
            $novaInformacao = informacao::novaInformacao($item['informacao'], $user);
            if ($novaInformacao->salvar() == false) {
                http_response_code(500);
                exit('Não está sendo possível salvar elementos no banco de dados no momento!');
            }
            $item['informacao'] = $novaInformacao;
            return $item;
        }, $filteredData);
        http_response_code('200');
        exit('Todas as informaçõess foram salvas com sucesso!');
    }
    public static function gerarUrl(string $page = null): string
    {

        $acao = implode('/', Routes::getLocalUrl());
        if (strpos($acao, '?') !== false) {
            $acao = substr($acao, 0, strpos($acao, '?'));
        }


        if ($page == null) {
            return Routes::HOME_PATH . $acao;
        }

        return Routes::HOME_PATH . $acao . '?' . http_build_query(['page' => $page]);;
    }
    public static function gerarPaginacao(int $totalPages, int $paginaAtual, int &$maxPages, int &$initialPage): void
    {
        if ($paginaAtual <= 5) {
            $maxPages = 9;
            $initialPage = 1;
        } else if ($paginaAtual <= $totalPages - 5) {
            $maxPages = $paginaAtual + 4;
            $initialPage = $paginaAtual - 4;
        } else {
            $maxPages = $totalPages;
            $initialPage = $totalPages - 5;
        }
    }
}
