<?php

namespace Models;

use DateTime;
use Exception;
use Models\model;
use PDO;

class informacao extends model
{
    public string $table_name = 'tb_informacao';
    protected string|null $id;
    protected string|null $informacao;
    protected string|null $dataCadastrada;
    protected string|null $dataAtualizacao;

    protected int $quemCadastrou;


    public function getId(): string|null
    {

        if (isset($this->id) && $this->id !== null)
            return $this->id;
        return null;
    }

    public function setId(string $id): void
    {
        $this->id = $id;
    }





    // Getter e Setter para $informacao
    public function getInformacao(): string|null
    {
        return $this->informacao;
    }

    public function setInformacao(string $informacao): void
    {
        $result = $this->filterVarString($informacao, 250, 5);
        if ($result == false)
            throw new Exception('A informação a ser cadastrada passou do limite. Que é 250 caracteres.');
        $this->informacao =  $result;
    }

    // Getter e Setter para $dataCadastrada
    public function getDataCadastrada(): string|null
    {
        return date('d/m/Y H:i:s', strtotime($this->dataCadastrada));
    }

    public function setDataCadastrada(): void
    {
        $this->dataCadastrada = date('Y-m-d H:i:s');
    }

    // Getter e Setter para $DataAtualizacao
    public function getDataAtualizacao(): string|null
    {
        if (isset($this->dataAtualizacao) && !empty($this->dataAtualizacao))
            return date('d/m/Y H:i:s', strtotime($this->dataAtualizacao));
        return null;
    }

    public function setDataAtualizacao(): void
    {
        $this->dataAtualizacao = date('Y-m-d H:i:s');
    }




    // Getter e Setter para $quemCadastrou
    public function getQuemCadastrou(): user | null
    {
        return user::buscarPorID($this->quemCadastrou);
    }
    public static function buscarPorID(int $id): informacao | null
    {
        $informacao = new informacao();
        $informacao = database::buscar($informacao->table_name, array('WHERE `id` = ? LIMIT 1', [$id]), 'Models\informacao');

        if (count($informacao) == 0)
            return null;
        $informacao = $informacao[0];
        return $informacao;
    }
    public function setQuemCadastrou(user $quemCadastrou): void
    {
        $this->quemCadastrou = $quemCadastrou->getID();
    }
    public function buscarInformacao()
    {

        if (!isset($this->id) || $this->id == null) {
            $informacao = database::buscar($this->table_name, array('WHERE `informacao` = ? AND `dataCadastrada` = ?  LIMIT 1', [$this->informacao, $this->dataCadastrada]), get_class($this));
            if (count($informacao) == 0)
                return false;
            $informacao = $informacao[0];
        } else {
            $informacao = database::buscar($this->table_name, array('WHERE `id` = ?  LIMIT 1', [$this->id]), get_class($this));
            if (count($informacao) == 0)
                return false;
            $informacao = $informacao[0];
        }
        $this->id = $informacao->id;
    }
    public function salvar(): bool
    {
        if (database::insertData($this->table_name, [
            'informacao' => $this->informacao,
            'dataCadastrada' => $this->dataCadastrada,
            'dataAtualizacao' => $this->dataAtualizacao ?? null,
            'quemCadastrou' => $this->quemCadastrou

        ]))
            return true;
        else
            return false;
    }
    public function getJsonObject()
    {
        return json_encode(get_object_vars($this));
    }
    public static function novaInformacao(string $informacao, user $quemCadastrou): informacao
    {
        $info = new informacao();
        $info->setInformacao($informacao);
        $info->setQuemCadastrou($quemCadastrou);
        $info->setDataCadastrada(date('d/m/Y H:i:s'));

        return $info;
    }
    public static function getInformacaoList(): array
    {
        $informacao = new informacao();
        return database::retrieveAllData($informacao->table_name, get_class($informacao));
    }
    public static function buscarPagina(int $limit, int $offset)
    {
        $informacao = new informacao();
        $informacao = database::retrieveDataPage($informacao->table_name, $limit, $offset, get_class($informacao));
        return $informacao;
    }
    public function atualizarInformacao(string $novaInformacao)
    {
        $this->setInformacao($novaInformacao);
        $this->setDataAtualizacao();
        database::update($this->table_name, ["`informacao` = ?,`dataAtualizacao` = ? WHERE `id` = ? LIMIT 1", [$this->informacao, $this->dataAtualizacao, $this->id]]);
    }
    public function deletarInformacao()
    {
        database::delete($this->table_name, ["`id` = ? LIMIT 1", [$this->id]]);
    }
}
