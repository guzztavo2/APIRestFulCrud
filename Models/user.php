<?php

namespace Models;

use Models\model;

class user extends model
{
    public string $table_name = 'tb_user';
    protected string $id;
    protected string $nomeUsuario;
    protected string $senhaUsuario;
    protected string|null $estaLogado;
    protected string|null $tokenAPI;
    public function setNomeUsuario($nomeUsuario)
    {
        $nomeUsuario = $this->filterVarString($nomeUsuario, 100, 5);
        $nomeUsuario = strtolower($nomeUsuario);
        if ($nomeUsuario == false)
            return ['fail' => 'Esse nome de usuário é inválido, tente novamente por favor. <br> É necessário ter um comprimento de 5 a 100 caracteres.'];
        $this->nomeUsuario = $nomeUsuario;
    }
    public function setSenhaUsuario($senhaUsuario)
    {
        $senhaUsuario = $this->filterVarString($senhaUsuario, 100, 5);

        if ($senhaUsuario == false)
            return ['fail' => 'Essa senha de usuário é inválido, tente novamente por favor. <br> É necessário ter um comprimento de 5 a 100 caracteres.'];
        $senhaUsuario = crypt($senhaUsuario, $this->nomeUsuario);
        $this->senhaUsuario = $senhaUsuario;
    }
    public function getID()
    {
        return $this->id;
    }
    public function getSenhaUsuario()
    {
        return $this->senhaUsuario;
    }
    public function getNomeUsuario()
    {
        return $this->nomeUsuario;
    }
    public function getEstaLogado()
    {
        return $this->estaLogado;
    }
    private function filterVarString($var, int $maxLenght, int $minLenght)
    {
        $var = filter_var($var, FILTER_DEFAULT);
        if (strlen($var) > $maxLenght || strlen($var) < $minLenght) {
            return false;
        }
        return $var;
    }
    public function salvar()
    {
        if (database::insertData($this->table_name, ['nomeUsuario' => $this->getNomeUsuario(), 'senhaUsuario' => $this->getSenhaUsuario()]))
            return ['success' => 'Usuário registrado com sucesso!'];
        else
            return ['fail' => 'Não foi possivel registrar a conta com sucesso!'];
    }
    public function setLogado(bool $nullToken = null)
    {
        if (isset($nullToken) && $nullToken == true)
            $this->estaLogado = null;

        else
            $this->estaLogado = uniqid();
    }
    public function getApiKEY(){
        return $this->tokenAPI;
    }
    public function setTokenAPI()
    {
      
        $tokenAPI = md5(crypt(uniqid(), 'apiKey'));
        $this->tokenAPI = $tokenAPI;
        database::update($this->table_name, ['`tokenAPI` = ? WHERE `id` = ?', [$tokenAPI, $this->id]]);
    }
    public function atualizar(string $novaSenha = null)
    {

        if ($novaSenha !== null) {
            $this->cloneUser(null, null, $novaSenha, $this->estaLogado);
            database::update($this->table_name, ['`senhaUsuario` = ?, `estaLogado` = ? WHERE `id` = ? LIMIT 1', [$novaSenha,  $this->estaLogado, $this->id]]);
            return;
        } else
            database::update($this->table_name, ['`estaLogado` = ? WHERE `id` = ? LIMIT 1', [$this->estaLogado, $this->id]]);
        $this->cloneUser(null, null, null, $this->estaLogado);
    }
    public function buscarPorNomeSenha()
    {
        $user = database::buscar($this->table_name, array('WHERE `nomeUsuario` = ? AND `senhaUsuario` = ? LIMIT 1', [$this->nomeUsuario, $this->senhaUsuario]),get_class($this));

        if ($user == false)
            return false;

        $this->cloneUser($user->id, $user->nomeUsuario, $user->senhaUsuario, $user->estaLogado, $user->tokenAPI);
    }

    public function buscarPorNome()
    {
        $user = new user();
        $user = database::buscar($this->table_name, array('WHERE `nomeUsuario` = ? LIMIT 1', [$this->nomeUsuario]),get_class($this));

        if ($user == false)
            return false;

            $this->cloneUser($user->id, $user->nomeUsuario, $user->senhaUsuario, $user->estaLogado, $user->tokenAPI);
        }
    public static function buscarPorToken(user $user): user|false
    {
        $user = database::buscar($user->table_name, array('WHERE `id` = ? AND `estaLogado` = ? LIMIT 1', [$user->getID(), $user->getEstaLogado()]),'Models\user');

        if ($user == false)
            return false;
        return $user;
    }
    public static function buscarPorID(int | string $id): user | false
    {
        $user = new user();
        $user = database::buscar($user->table_name, array('WHERE `id` = ? LIMIT 1', [$id]),'Models\user');

        if ($user == false)
            return false;

        return $user;
    }
    public function getJsonObject()
    {
        return json_encode(get_object_vars($this));
    }
    public function cloneUser(string $id = null, string $nomeUsuario = null, string $senhaUsuario = null, string | null $estaLogado = null, string | null $tokenAPI = null)
    {
        if ($id !== null) $this->id = $id;
        if ($nomeUsuario !== null) $this->nomeUsuario = $nomeUsuario;
        if ($senhaUsuario !== null) $this->senhaUsuario = $senhaUsuario;
        if ($estaLogado !== null) $this->estaLogado = $estaLogado;
        if($tokenAPI !== null) $this->tokenAPI = $tokenAPI;
    }
}
