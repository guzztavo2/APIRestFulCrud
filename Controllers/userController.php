<?php

namespace Controllers;

use Models\user;
use Routes;

class userController extends Controller
{
    public static function verificarTokenUser()
    {
        $user = self::getSessionUserLogado();
        if ($user == null)
            return;

        if (user::buscarPorToken($user) == false) {
            self::removeSessionUser();
            $_SESSION['fail'] = 'Este usuário já existe outra sessão. Por favor, verifique ou logue novamente e/ou troque sua senha.';
            Routes::redirecionarURL('user/logar');
        }
    }
    public static function trocarSenha($postRequest = null)
    {
        if ($postRequest == null) {
            self::verificarLogadoRedirect();
            $token_csrf = md5(uniqid());
            $_SESSION['token'] = $token_csrf;
            if (isset($_SESSION['fail'])) {
                $fail = $_SESSION['fail'];
                unset($_SESSION['fail']);
                self::includeFile('trocarSenha.php', array('token' => $token_csrf, 'fail' => $fail));
            }
            if (isset($_SESSION['success'])) {
                $success = $_SESSION['success'];
                unset($_SESSION['success']);
                self::includeFile('trocarSenha.php', array('token' => $token_csrf, 'success' => $success));
            }
            if (isset($_SESSION['senhaNova']) && $_SESSION['senhaNova'] == false) {
                $_SESSION['senhaNova'] = true;
                self::includeFile('trocarSenha.php', array('token' => $token_csrf, 'senhaNova' => true));
            }

            self::includeFile('trocarSenha.php', ['token' => $token_csrf]);
        } else {
            $warningRedirect = function (string $message, bool $isSuccess = null) {
                if ($isSuccess == null)
                    $_SESSION['fail'] = $message;
                else
                    $_SESSION['success'] = $message;
                routes::redirecionarURL('user/trocarsenha');
            };
            if (isset($_SESSION['senhaNova']) && $_SESSION['senhaNova'] == true) {
                unset($_SESSION['senhaNova']);

                if (strcmp($postRequest['senhaNova'], $postRequest['senhaNova_1']) !== 0)
                    $warningRedirect('As senhas não são iguais, tanto a nova senha e a de confirmação são necessárias serem iguais.');

                $user = new user();
                $user->setNomeUsuario(self::getSessionUserLogado()->getNomeUsuario());
                $user->setSenhaUsuario($postRequest['senhaNova']);

                if (strcmp(self::getSessionUserLogado()->getSenhaUsuario(), $user->getSenhaUsuario()) == 0)
                    $warningRedirect('A senha antiga e a senha atual, não podem ser iguais.');
                $user->buscarPorNome();

                $user->setSenhaUsuario($postRequest['senhaNova']);

                $user->atualizar($user->getSenhaUsuario());
                self::setSessionUserLogado($user);
                $warningRedirect('As senhas foram trocadas e concluidas com sucesso! Quando for acessar sua conta novamente, terá de usar sua nova senha', true);
            } else
                $warningRedirect('Requisição inválida, por favor, insira sua senha atual novamente, para poder troca-la.');
        }
    }
    public static function setSessionUserLogado(user $user)
    {

        $_SESSION['userLogado'] = $user->getJsonObject();
    }
    public static function getSessionUserLogado()
    {
        if (isset($_SESSION['userLogado']) && $_SESSION['userLogado'] !== null) {
            $user = json_decode($_SESSION['userLogado']);
            $user_1 = new user();
            $user_1->cloneUser($user->id, $user->nomeUsuario, $user->senhaUsuario, $user->estaLogado, $user->tokenAPI);
            return $user_1;
        }

        return null;
    }
    private static function removeSessionUser()
    {
        unset($_SESSION['userLogado']);
    }
    public static function configuracao()
    {
        self::verificarLogadoRedirect();
        self::includeFile('accountConfig.php');
    }

    public static function verificarSenha($postRequest)
    {
        self::verificarTokenSession($postRequest);

        $errorRedirect = function (string $message) {
            $_SESSION['fail'] = $message;
            Routes::redirecionarURL('user/trocarsenha');
        };
        if (strcmp($postRequest['senhaAntiga'], $postRequest['senhaAntiga_1']) !== 0)
            $errorRedirect('As senhas informadas não são iguais, tente novamente.');


        $user = new User();
        $user->setNomeUsuario(self::getSessionUserLogado()->getNomeUsuario());
        $user->setSenhaUsuario($postRequest['senhaAntiga']);

        if ($user->buscarPorNomeSenha() == false && $user->buscarPorNomeSenha() !== null || strcmp(self::getSessionUserLogado()->getID(), $user->getID()) !== 0)
            $errorRedirect('Essa senha não é a correta de sua conta, favor tentar novamente.');

        $_SESSION['senhaNova'] = false;
        Routes::redirecionarURL('user/trocarsenha');
    }
    public static function Create()
    {
        $token_csrf = md5(uniqid());
        $_SESSION['token'] = $token_csrf;
        if (isset($_SESSION['fail'])) {
            $fail = $_SESSION['fail'];
            unset($_SESSION['fail']);
            self::includeFile('criarConta.php', array('token' => $token_csrf, 'fail' => $fail));
        }
        if (isset($_SESSION['success'])) {
            $success = $_SESSION['success'];
            unset($_SESSION['success']);
            self::includeFile('criarConta.php', array('token' => $token_csrf, 'success' => $success));
        }

        self::includeFile('criarConta.php', array('token' => $token_csrf));
    }
    public static function verificarLogadoRedirect()
    {
        if (self::getSessionUserLogado() == null)
            Routes::redirecionarURL('user/logar');
    }
    public static function mainConta()
    {
        self::verificarLogadoRedirect();

        self::includeFile('accountMain.php');
    }
    public static function Login()
    {
        if (self::getSessionUserLogado() !== null)
            self::logout();

        $token_csrf = md5(uniqid());
        $_SESSION['token'] = $token_csrf;
        if (isset($_SESSION['fail'])) {
            $fail = $_SESSION['fail'];
            unset($_SESSION['fail']);
            self::includeFile('logarConta.php', array('token' => $token_csrf, 'fail' => $fail));
        }
        if (isset($_SESSION['success'])) {
            $success = $_SESSION['success'];
            unset($_SESSION['success']);
            self::includeFile('logarConta.php', array('token' => $token_csrf, 'success' => $success));
        }


        self::includeFile('logarConta.php', ['token' => $token_csrf]);
    }
    private static function verificarTokenSession($postRequest)
    {
        if (strcmp($postRequest['token'], $_SESSION['token']) !== 0) {

            $_SESSION['fail'] = 'Por favor, não foi possível validar a requisição, tente novamente.';
            Routes::redirecionarURL('user/logar');
        }
    }
    public static function acessarConta($postRequest)
    {

        self::verificarTokenSession($postRequest);
        $user = new user();

        if (isset($user->setNomeUsuario($postRequest['nomeUsuario'])['fail'])) {
            $_SESSION['fail'] = $user->setNomeUsuario($postRequest['nomeUsuario'])['fail'];
            Routes::redirecionarURL('user/logar');
        }
        if (isset($user->setSenhaUsuario($postRequest['senhaUsuario'])['fail'])) {
            $_SESSION['fail'] = $user->setSenhaUsuario($postRequest['senhaUsuario'])['fail'];
            Routes::redirecionarURL('user/logar');
        }

        if ($user->buscarPorNomeSenha() === false) {
            $_SESSION['fail'] = 'Esse usuário e/ou essa senha não foi válida, por favor, tente novamente.';
            Routes::redirecionarURL('user/logar');
        }
        $user->setLogado();
        $user->atualizar();
        $user->buscarPorNome();
        self::setSessionUserLogado($user);
        Routes::redirecionarURL('home');
    }
    public static function logout()
    {
        $user = user::buscarPorID(self::getSessionUserLogado()->getID());
        $user->setLogado(true);
        $user->atualizar(null);
        self::removeSessionUser();
        Routes::redirecionarURL('home');
    }
    public static function criarConta($postRequest)
    {
        self::verificarTokenSession($postRequest);

        $user = new user();
        $warningRedirect = function (string $message, bool $isSucess = null) {
            if ($isSucess == null)
                $_SESSION['fail'] = $message;

            else
                $_SESSION['success'] = $message;

            Routes::redirecionarURL('user/criar');
        };
        if (isset($user->setNomeUsuario($postRequest['nomeUsuario'])['fail']))
            $warningRedirect($user->setNomeUsuario($postRequest['nomeUsuario'])['fail']);

        if (isset($user->setSenhaUsuario($postRequest['senhaUsuario'])['fail']))
            $warningRedirect($user->setSenhaUsuario($postRequest['nomeUsuario'])['fail']);

        $resultado = $user->buscarPorNome();
        if ($resultado !== false && $resultado == null)
            $warningRedirect('Esse nome de usuário já está registrado, você terá de escolher outro!');

        $resultado = $user->salvar();
        $user->buscarPorNome();
        $user->setTokenAPI();
        if (isset($resultado['success']))
            $warningRedirect($resultado['success'], true);

        if (isset($resultado['fail']))
            $warningRedirect($resultado['fail']);
    }
}
